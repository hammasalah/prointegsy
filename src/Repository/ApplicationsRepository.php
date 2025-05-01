<?php
// src/Repository/ApplicationsRepository.php
namespace App\Repository;

use App\Entity\Applications;
use App\Entity\Jobs;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ApplicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Applications::class);
    }

    /**
     * Build a new Applications entity (without persisting).
     *
     * @throws \LogicException if the user has already applied to this job
     */
    public function createApplication(?Users $user, Jobs $job): Applications
    {
        // 1. Prevent duplicates
        $existing = $this->createQueryBuilder('a')
            ->andWhere('a.userId = :user')
            ->andWhere('a.jobId  = :job')
            ->setParameters(new \Doctrine\Common\Collections\ArrayCollection(['user' => $user, 'job' => $job]))
            ->getQuery()
            ->getOneOrNullResult();

        if ($existing) {
            throw new \LogicException('You have already applied to this job.');
        }

        // 2. Build new Applications
        $application = new Applications();
        $application->setUserId($user);
        $application->setJobId($job);          
        $application->setStatus('pending');
        $application->setAppliedAt((new \DateTimeImmutable())->format('Y-m-d H:i:s'));

        return $application;
    }



public function findAllApplications(): array
{
    return $this->createQueryBuilder('a')
        ->leftJoin('a.user_id', 'u')
        ->leftJoin('a.job_id', 'j')
        ->addSelect('u', 'j')
        ->orderBy('a.appliedAt', 'DESC')
        ->getQuery()
        ->getResult();
}

}
