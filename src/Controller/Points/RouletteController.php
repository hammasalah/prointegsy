<?php

namespace App\Controller\Points;
use App\Entity\Roulette;
use App\Entity\HistoriquePoints;
use App\Entity\Users;
use App\Repository\HistoriquePointsRepository;
use App\Service\RouletteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RouletteController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/points', name: 'app_points')]
    public function points(): Response
    {
        return $this->render('points/index.html.twig');
    }

    #[Route('/points/convert', name: 'app_convert_points')]
    public function convertPoints(): Response
    {
        return $this->render('points/convert.html.twig');
    }

    #[Route('/points/roulette-test', name: 'app_roulette_test')]
    public function rouletteTest(): Response
    {
        return $this->render('points/roulette_test.html.twig');
    }

    #[Route('/points/fortune-wheel', name: 'app_fortune_wheel', methods: ['GET', 'POST'])]
    public function fortuneWheel(Request $request, EntityManagerInterface $entityManager, RouletteService $rouletteService, SessionInterface $session): Response
    {
        try {
            // Récupérer l'utilisateur connecté depuis la session
            $sessionUser = $session->get('user');
            if (!$sessionUser) {
                return $this->redirectToRoute('app_login');
            }
            
            // Récupérer l'utilisateur complet depuis la base de données avec son ID réel
            $userRepository = $entityManager->getRepository(Users::class);
            $user = $userRepository->find($sessionUser->getId());
            
            if (!$user) {
                throw new \Exception('Utilisateur non trouvé avec ID ' . $sessionUser->getId());
            }

            // Vérifier si l'utilisateur est une instance de la classe Users
            if (!$user instanceof Users) {
                throw new \Exception('Utilisateur invalide : l\'objet n\'est pas une instance de Users');
            }

            // Gérer les requêtes POST (depuis AJAX)
            if ($request->isMethod('POST')) {
                // Définir explicitement les en-têtes de réponse pour toutes les réponses
                $responseHeaders = [
                    'Content-Type' => 'application/json',
                    'X-Content-Type-Options' => 'nosniff',
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                    'Access-Control-Allow-Origin' => '*'
                ];

                // Récupérer et décoder les données JSON
                $content = $request->getContent();
                if (empty($content)) {
                    $response = new JsonResponse(['success' => false, 'message' => 'Aucune donnée reçue'], 400);
                    foreach ($responseHeaders as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    return $response;
                }

                $data = json_decode($content, true);
                if ($data === null) {
                    // Si json_decode échoue, vérifier si le contenu est valide
                    $response = new JsonResponse(['success' => false, 'message' => 'Données JSON invalides: ' . json_last_error_msg()], 400);
                    foreach ($responseHeaders as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    return $response;
                }

                $segmentIndex = $data['segmentIndex'] ?? null;

                if ($segmentIndex === null || !is_numeric($segmentIndex) || $segmentIndex < 0 || $segmentIndex > 4) {
                    $response = new JsonResponse(['success' => false, 'message' => 'Index de segment invalide'], 400);
                    foreach ($responseHeaders as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    return $response;
                }

                // Définir les segments côté serveur (même structure que côté client)
                $segments = [
                    ['label' => '0 Points', 'points' => 0],
                    ['label' => '100 Points', 'points' => 100],
                    ['label' => '50 Points', 'points' => 50],
                    ['label' => '40 Points', 'points' => 40],
                    ['label' => 'Bonus: 200 Points', 'points' => 200],
                ];
                
                // Log pour déboguer l'index reçu
                error_log('Index de segment reçu: ' . $segmentIndex . ', points correspondants: ' . $segments[$segmentIndex]['points']);

                // Vérifier que l'index du segment existe bien dans le tableau
                if (!isset($segments[$segmentIndex])) {
                    $response = new JsonResponse(['success' => false, 'message' => 'Index de segment non trouvé: ' . $segmentIndex], 400);
                    foreach ($responseHeaders as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    return $response;
                }

                $reward = $segments[$segmentIndex]['label'];
                $pointsWon = (int)$segments[$segmentIndex]['points']; // Conversion explicite en entier

                // Vérifier si les méthodes existent pour éviter les erreurs de mapping
                if (!method_exists($user, 'getPoints') || !method_exists($user, 'setPoints')) {
                    throw new \Exception('Les méthodes getPoints ou setPoints ne sont pas définies pour l\'utilisateur');
                }

                try {
                    // Vérifier si l'utilisateur peut encore tourner la roue aujourd'hui
                    if (method_exists($rouletteService, 'canSpin')) {
                        $canSpin = $rouletteService->canSpin($user);
                        if (!$canSpin) {
                            $response = new JsonResponse([
                                'success' => false,
                                'message' => 'Vous avez atteint le nombre maximum de tours pour aujourd\'hui',
                                'remainingSpins' => 0
                            ]);
                            foreach ($responseHeaders as $key => $value) {
                                $response->headers->set($key, $value);
                            }
                            return $response;
                        }
                        // Log pour déboguer
                        error_log('L\'utilisateur peut tourner la roue: ' . ($canSpin ? 'oui' : 'non'));
                    }
                    
                    // Mettre à jour les points de l'utilisateur
                    $currentPoints = $user->getPoints() ?? 0;
                    
                    // Vérifier que pointsWon est bien un entier valide
                    if (!is_int($pointsWon)) {
                        throw new \Exception('Valeur de points invalide: ' . var_export($pointsWon, true));
                    }
                    
                    // Vérifier que la somme ne dépasse pas la capacité d'un entier
                    if ($currentPoints > PHP_INT_MAX - $pointsWon) {
                        throw new \Exception('Dépassement de la valeur maximale de points');
                    }
                    
                    $user->setPoints($currentPoints + $pointsWon);
                    
                    // Enregistrer le spin dans la table roulette
                    $roulette = new Roulette();
                    if (!$user->getId()) {
                        throw new \Exception('Utilisateur invalide : ID manquant');
                    }
                    $roulette->setUser($user);
                    $roulette->setResult($pointsWon . ' points');
                    // Vérifier si la méthode setCreatedAt existe
                    if (!method_exists($roulette, 'setCreatedAt')) {
                        throw new \Exception('La méthode setCreatedAt n\'est pas définie pour l\'entité Roulette');
                    }
                    // Utiliser la méthode setCreatedAt avec un objet DateTime compatible
                    $roulette->setCreatedAt(new \DateTime());
                    
                    // Log pour déboguer
                    error_log('Roulette créée avec succès pour l\'utilisateur ID: ' . $user->getId() . ', points gagnés: ' . $pointsWon);
                    
                    // Enregistrer l'historique des points dans la table historique_points
                    $historique = new HistoriquePoints();
                    $historique->setUser($user);
                    // Vérifier si les méthodes nécessaires existent
                    if (!method_exists($historique, 'setType')) {
                        throw new \Exception('La méthode setType n\'est pas définie pour l\'entité HistoriquePoints');
                    }
                    if (!method_exists($historique, 'setPoints')) {
                        throw new \Exception('La méthode setPoints n\'est pas définie pour l\'entité HistoriquePoints');
                    }
                    if (!method_exists($historique, 'setRaison')) {
                        throw new \Exception('La méthode setRaison n\'est pas définie pour l\'entité HistoriquePoints');
                    }
                    if (!method_exists($historique, 'setDate')) {
                        throw new \Exception('La méthode setDate n\'est pas définie pour l\'entité HistoriquePoints');
                    }
                    $historique->setType('gain');
                    $historique->setPoints($pointsWon);
                    $historique->setRaison('Roulette');
                    // Utiliser la méthode setDate avec un objet DateTime compatible
                    $historique->setDate(new \DateTime());
                    
                    // Vérifier les entités avant de persister
                    if ($roulette->getUser() === null || $historique->getUser() === null) {
                        throw new \Exception('Utilisateur non défini dans Roulette ou HistoriquePoints');
                    }
                    
                    // Utiliser le service RouletteService pour la validation supplémentaire
                    try {
                        // Vérifier si le service a les méthodes nécessaires
                        if (method_exists($rouletteService, 'validateRouletteData')) {
                            $rouletteService->validateRouletteData($user, $pointsWon);
                        }
                    } catch (\Exception $e) {
                        // Log l'erreur mais continuer le processus
                        error_log('Erreur lors de la validation avec RouletteService: ' . $e->getMessage());
                        // Ne pas lancer d'exception ici pour éviter l'erreur 500
                    }
                    
                    // Persister les changements
                    $entityManager->persist($user);
                    $entityManager->persist($roulette);
                    $entityManager->persist($historique);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    // Log détaillé de l'erreur
                    error_log('Erreur lors de la mise à jour des points: ' . $e->getMessage() . ' à ' . $e->getFile() . ' ligne ' . $e->getLine());
                    error_log('Trace: ' . $e->getTraceAsString());
                    
                    // Renvoyer une réponse JSON avec l'erreur au lieu de lancer une exception
                    $response = new JsonResponse([
                        'success' => false,
                        'message' => 'Une erreur est survenue lors de la sauvegarde des points : ' . $e->getMessage(),
                        'error' => true
                    ], 200); // Code 200 pour éviter les erreurs AJAX, mais avec un flag d'erreur
                    
                    foreach ($responseHeaders as $key => $value) {
                        $response->headers->set($key, $value);
                    }
                    
                    return $response;
                }

                // Définir les en-têtes de réponse explicitement
                $response = new JsonResponse([
                    'success' => true,
                    'reward' => $reward,
                    'totalPoints' => $user->getPoints(),
                    'pointsWon' => $pointsWon,
                ]);
                
                foreach ($responseHeaders as $key => $value) {
                    $response->headers->set($key, $value);
                }
                
                return $response;
            }

            // Gérer les requêtes GET (affichage de la page)
            return $this->render('points/fortune_wheel.html.twig', [
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            // Log détaillé avec la trace complète de l'erreur
            $errorMessage = 'Erreur serveur : ' . $e->getMessage() . ' à ' . $e->getFile() . ' ligne ' . $e->getLine();
            $trace = $e->getTraceAsString();
            error_log('Erreur dans fortuneWheel: ' . $errorMessage);
            error_log('Trace: ' . $trace);
            
            // Ajouter des logs spécifiques pour les erreurs courantes
            if (strpos($e->getMessage(), 'setCreatedAt') !== false) {
                error_log('Erreur avec la méthode setCreatedAt dans l\'entité Roulette');
            } elseif (strpos($e->getMessage(), 'setDate') !== false) {
                error_log('Erreur avec la méthode setDate dans l\'entité HistoriquePoints');
            } elseif (strpos($e->getMessage(), 'getPoints') !== false || strpos($e->getMessage(), 'setPoints') !== false) {
                error_log('Erreur avec les méthodes getPoints ou setPoints dans l\'entité Users');
            }

            // Définir les en-têtes de réponse standard pour toutes les réponses d'erreur
            $responseHeaders = [
                'Content-Type' => 'application/json',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Access-Control-Allow-Origin' => '*'
            ];

            // Vérifier si la requête attend une réponse JSON (AJAX ou en-tête Accept)
            $isJsonRequest = $request->isXmlHttpRequest() ||
                $request->headers->get('Accept') === 'application/json' ||
                $request->getContentType() === 'json' ||
                $request->isMethod('POST');

            if ($isJsonRequest) {
                // Renvoyer du JSON pour les requêtes AJAX ou POST
                $response = new JsonResponse([
                    'success' => false,
                    'message' => 'Erreur lors du traitement de la requête: ' . $e->getMessage(),
                    'debug' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'type' => get_class($e)
                    ]
                ], 500);

                // Appliquer tous les en-têtes de réponse
                foreach ($responseHeaders as $key => $value) {
                    $response->headers->set($key, $value);
                }

                return $response;
            } else {
                // Pour les requêtes GET normales, afficher la page avec un message d'erreur
                return $this->render('points/fortune_wheel.html.twig', [
                    'user' => null,
                    'error' => $errorMessage
                ]);
            }
        }
    }
}