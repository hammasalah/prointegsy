<?php

namespace App\Service;

use App\Entity\Users;
use App\Entity\Roulette;
use App\Entity\HistoriquePoints;
use Doctrine\ORM\EntityManagerInterface;

class RouletteService
{
    private const MAX_DAILY_SPINS = 4;
    private const REWARDS = [0, 40, 50, 100, 200];

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function canSpin(Users $user): bool
    {
        $today = new \DateTime('today');
        if ($today->format('d') !== '01') {
            return false;
        }

        $spinCount = $this->entityManager->getRepository(Roulette::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.user = :user')
            ->andWhere('r.date >= :startOfDay')
            ->andWhere('r.date < :endOfDay')
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
            ->andWhere('r.date >= :startOfDay')
            ->andWhere('r.date < :endOfDay')
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

        // Ajouter les points
        $currentPoints = $user->getPoints() ?? 0;
        $user->setPoints($currentPoints + $reward);

        // Enregistrer le tour
        $rouletteSpin = new Roulette();
        $rouletteSpin->setUser($user);
        $rouletteSpin->setPointsGagnes($reward);
        $rouletteSpin->setDate(new \DateTime());

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
        ];
    }

    public function getSpinHistory(Users $user, int $limit = 5): array
    {
        return $this->entityManager->getRepository(Roulette::class)->findBy(
            ['user' => $user],
            ['date' => 'DESC'],
            $limit
        );
    }
}