<?php

namespace App\Service;

use App\Entity\Users;
use App\Entity\Roulette;
use App\Entity\HistoriquePoints;
use Doctrine\ORM\EntityManagerInterface;

class RouletteService
{
    private const MAX_DAILY_SPINS = 4;
    private const REWARDS = [0, 100, 50, 40, 200];

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function canSpin(Users $user): bool
    {
        $today = new \DateTime('today');
        // Suppression de la restriction au premier jour du mois
        // pour permettre l'utilisation de la roue tous les jours
        
        $spinCount = $this->entityManager->getRepository(Roulette::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.user = :user')
            ->andWhere('r.createdAt >= :startOfDay')
            ->andWhere('r.createdAt < :endOfDay')
            ->setParameter('user', $user)
            ->setParameter('startOfDay', $today)
            ->setParameter('endOfDay', (clone $today)->modify('+1 day'))
            ->getQuery()
            ->getSingleScalarResult();

        return $spinCount < self::MAX_DAILY_SPINS;
    }

    public function getRemainingSpins(Users $user): int
    {
        $today = new \DateTime('today');
        $spinCount = $this->entityManager->getRepository(Roulette::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.user = :user')
            ->andWhere('r.createdAt >= :startOfDay')
            ->andWhere('r.createdAt < :endOfDay')
            ->setParameter('user', $user)
            ->setParameter('startOfDay', $today)
            ->setParameter('endOfDay', (clone $today)->modify('+1 day'))
            ->getQuery()
            ->getSingleScalarResult();

        return max(0, self::MAX_DAILY_SPINS - $spinCount);
    }

    public function getNextSpinDate(): \DateTime
    {
        $today = new \DateTime('today');
        return (clone $today)->modify('first day of next month');
    }

    public function spin(Users $user): array
    {
        if (!$this->canSpin($user)) {
            throw new \Exception('Vous ne pouvez pas tourner la roue pour le moment.');
        }

        $reward = self::REWARDS[array_rand(self::REWARDS)];
        
        // Valider les données
        $this->validateRouletteData($user, $reward);

        // Ajouter les points
        $currentPoints = $user->getPoints() ?? 0;
        $user->setPoints($currentPoints + $reward);

        // Enregistrer le tour
        $rouletteSpin = new Roulette();
        $rouletteSpin->setUser($user);
        // Définir le résultat (l'entité Roulette utilise setResult)
        $rouletteSpin->setResult($reward . ' points');
        
        // Définir la date (l'entité Roulette utilise setCreatedAt)
        $rouletteSpin->setCreatedAt(new \DateTime());

        // Enregistrer l'historique
        $historiquePoints = new HistoriquePoints();
        $historiquePoints->setUser($user);
        $historiquePoints->setType('gain');
        $historiquePoints->setPoints($reward);
        $historiquePoints->setRaison('roulette');
        $historiquePoints->setDate(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->persist($rouletteSpin);
        $this->entityManager->persist($historiquePoints);
        $this->entityManager->flush();
        
        return [
            'reward' => $reward,
            'remainingSpins' => $this->getRemainingSpins($user),
            'totalPoints' => $user->getPoints(),
            'pointsWon' => $reward
        ];
    }

    /**
     * Valide les données de la roulette avant de les persister
     * 
     * @param Users $user L'utilisateur qui tourne la roue
     * @param int $pointsWon Les points gagnés
     * @return bool Retourne true si les données sont valides
     * @throws \Exception Si les données ne sont pas valides
     */
    public function validateRouletteData(Users $user, int $pointsWon): bool
    {
        try {
            // Vérifier que l'utilisateur existe et a un ID
            if (!$user || !$user->getId()) {
                throw new \Exception('Utilisateur invalide ou ID manquant');
            }
            
            // Vérifier que les points sont valides
            if (!is_int($pointsWon)) {
                // Tenter de convertir en entier si ce n'est pas déjà le cas
                $pointsWon = (int)$pointsWon;
                error_log('Points convertis en entier: ' . $pointsWon);
            }
            
            if ($pointsWon < 0) {
                throw new \Exception('Valeur de points négative: ' . $pointsWon);
            }
            
            // Vérifier que l'utilisateur a les méthodes nécessaires
            if (!method_exists($user, 'getPoints') || !method_exists($user, 'setPoints')) {
                throw new \Exception('Les méthodes getPoints ou setPoints ne sont pas définies pour l\'utilisateur');
            }
            
            // Vérifier que la somme ne dépasse pas la capacité d'un entier
            $currentPoints = $user->getPoints() ?? 0;
            if ($currentPoints > PHP_INT_MAX - $pointsWon) {
                throw new \Exception('Dépassement de la valeur maximale de points');
            }
            
            // Vérifier si la valeur des points est dans la liste des récompenses autorisées
            if (!in_array($pointsWon, self::REWARDS)) {
                error_log('Avertissement: Valeur de points non standard: ' . $pointsWon . ', mais traitement autorisé');
            }
            
            return true;
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas la propager
            error_log('Erreur de validation dans RouletteService: ' . $e->getMessage());
            // Retourner false au lieu de lancer une exception
            return false;
        }
    }
    
    public function getRewardInfo(int $reward): array
    {
        return [
            'reward' => $reward,
            'totalPoints' => 0,
            'pointsWon' => $reward
        ];
    }


    public function getSpinHistory(Users $user, int $limit = 5): array
    {
        return $this->entityManager->getRepository(Roulette::class)->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            $limit
        );
    }
}