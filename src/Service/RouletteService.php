<?php

namespace App\Service;

use App\Entity\Users;
use App\Entity\Roulette;
use App\Entity\HistoriquePoints;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class RouletteService
{
    private const MAX_DAILY_SPINS = 4;
    private const REWARDS = [0, 40, 50, 100, 200]; // Récompenses possibles

    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * Vérifie si l'utilisateur peut tourner la roulette.
     */
    public function canSpin(Users $user): bool
    {
        $today = new \DateTime('today');
        
        // Vérifier si aujourd'hui est le 1er jour du mois
        if ($today->format('d') !== '01') {
            return false;
        }

        // Compter le nombre de tours effectués aujourd'hui
        $spinCount = $this->entityManager->getRepository(Roulette::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.user_id = :user')
            ->andWhere('r.date >= :startOfDay')
            ->andWhere('r.date < :endOfDay')
            ->setParameter('user', $user)
            ->setParameter('startOfDay', $today)
            ->setParameter('endOfDay', (clone $today)->modify('+1 day'))
            ->getQuery()
            ->getSingleScalarResult();

        return $spinCount < self::MAX_DAILY_SPINS;
    }

    /**
     * Obtient le nombre de tours restants pour aujourd'hui.
     */
    public function getRemainingSpins(Users $user): int
    {
        $today = new \DateTime('today');
        $spinCount = $this->entityManager->getRepository(Roulette::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.user_id = :user')
            ->andWhere('r.date >= :startOfDay')
            ->andWhere('r.date < :endOfDay')
            ->setParameter('user', $user)
            ->setParameter('startOfDay', $today)
            ->setParameter('endOfDay', (clone $today)->modify('+1 day'))
            ->getQuery()
            ->getSingleScalarResult();

        return max(0, self::MAX_DAILY_SPINS - $spinCount);
    }

    /**
     * Obtient la date du prochain tour possible.
     */
    public function getNextSpinDate(): \DateTime
    {
        $today = new \DateTime('today');
        if ($today->format('d') === '01') {
            // Si on est le 1er, le prochain tour est le 1er du mois suivant
            return (clone $today)->modify('first day of next month');
        }
        // Sinon, le prochain tour est le 1er du mois actuel
        return (clone $today)->modify('first day of this month');
    }

    /**
     * Effectue un tour de roulette et attribue une récompense.
     */
    public function spin(Users $user): array
    {
        if (!$this->canSpin($user)) {
            throw new \Exception('You cannot spin the wheel at this time.');
        }

        // Générer une récompense aléatoire
        $reward = self::REWARDS[array_rand(self::REWARDS)];

        // Ajouter les points à l'utilisateur
        $user->addPoints($reward);
        $this->entityManager->persist($user);

        // Enregistrer le tour dans la table roulette
        $rouletteSpin = new Roulette();
        $rouletteSpin->setUserId($user);
        $rouletteSpin->setPointsGagnes($reward);
        $rouletteSpin->setDate(new \DateTime());
        $this->entityManager->persist($rouletteSpin);

        // Enregistrer le gain dans l'historique
        $historiquePoints = new HistoriquePoints();
        $historiquePoints->setUserId($user);
        $historiquePoints->setType('gain');
        $historiquePoints->setPoints($reward);
        $historiquePoints->setRaison('roulette');
        $historiquePoints->setDate(new \DateTime());
        $this->entityManager->persist($historiquePoints);

        // Sauvegarder les changements
        $this->entityManager->flush();

        return [
            'reward' => $reward,
            'remainingSpins' => $this->getRemainingSpins($user),
        ];
    }

    /**
     * Obtient l'historique des gains de la roulette pour un utilisateur.
     */
    public function getSpinHistory(Users $user, int $limit = 5): array
    {
        return $this->entityManager->getRepository(Roulette::class)->findBy(
            ['user_id' => $user],
            ['date' => 'DESC'],
            $limit
        );
    }
}