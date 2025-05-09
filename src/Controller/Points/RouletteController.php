<?php

namespace App\Controller\Points;

use App\Entity\User;
use App\Entity\UserRewards;
use App\Entity\HistoriquePoints;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class RouletteController extends AbstractController
{
    #[Route('/points/fortune-wheel', name: 'points_fortune')]
    public function fortuneWheel(Request $request)
    {
        // Code original pour la vérification du premier jour du mois
        // À décommenter après les tests
        /*
        $date = new \DateTime($request->query->get('date')); // Récupère la date passée dans l'URL
        $isFirstDayOfMonth = $date->format('d') === '01'; // Vérifie si c'est le 1er jour du mois
        */
        
        // Pour les tests : permettre l'utilisation de la roue à tout moment
        $isFirstDayOfMonth = true;
    
        return $this->render('points/fortune-wheel.html.twig', [
            'isFirstDayOfMonth' => $isFirstDayOfMonth,
        ]);
    }

    #[Route('/points/fortune-wheel/spin', name: 'points_fortune_spin', methods: ['POST'])]
    public function spin(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);
        $pointsGagnes = $data['points'] ?? 0;

        if ($pointsGagnes > 0) {
            // Mise à jour des points de l'utilisateur
            $pointsActuels = $user->getPoints() ?? 0;
            $user->setPoints($pointsActuels + $pointsGagnes);

            // Création d'une entrée dans l'historique des points
            $historique = new HistoriquePoints();
            $historique->setUser($user);
            $historique->setPoints($pointsGagnes);
            $historique->setDate(new \DateTime());
            $historique->setType('roulette');

            // Création d'une entrée dans les récompenses utilisateur
            $reward = new UserRewards();
            $reward->setUserId($user->getId());
            $reward->setPointsEarned($pointsGagnes);
            $reward->setEventId(1); // ID pour l'événement roulette
            $reward->setRewardId(1); // ID pour la récompense de type points
            $reward->setErnedAt((new \DateTime())->format('Y-m-d H:i:s'));

            $entityManager->persist($historique);
            $entityManager->persist($reward);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'points' => $pointsGagnes,
                'totalPoints' => $user->getPoints()
            ]);
        }

        return new JsonResponse(['error' => 'Points invalides'], Response::HTTP_BAD_REQUEST);
    }
    

}
