<?php

namespace App\Repository;

use App\Entity\UserGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserGroups>
 *
 * @method UserGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroups[]    findAll()
 * @method UserGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroups::class);
    }

    /**
     * Recherche des groupes par nom ou description
     * 
     * @param string $searchTerm Le terme de recherche
     * @return UserGroups[] Returns an array of UserGroups objects
     */
    public function searchGroups(string $searchTerm): array
    {
        return $this->createQueryBuilder('g')
            ->where('g.name LIKE :searchTerm')
            ->orWhere('g.description LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('g.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?UserGroups
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
