<?php

namespace App\Repository;

use App\Entity\HistoriquePoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoriquePoints>
 *
 * @method HistoriquePoints|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriquePoints|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriquePoints[]    findAll()
 * @method HistoriquePoints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriquePointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriquePoints::class);
    }

//    /**
//     * @return HistoriquePoints[] Returns an array of HistoriquePoints objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoriquePoints
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
