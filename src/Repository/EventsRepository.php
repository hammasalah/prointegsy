<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Users;

/**
 * @extends ServiceEntityRepository<Events>
 *
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }



    public function findByOrganizer(Users $organizer): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.organizerId = :organizer')
            ->setParameter('organizer', $organizer)
            ->orderBy('e.startTime', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByNameDescriptionCategory(?string $searchTerm, ?int $categoryId): array
    {
        $queryBuilder = $this->createQueryBuilder('e')
            // Jointure optionnelle mais recommandée si vous accédez aux données de catégorie
            ->leftJoin('e.categoryId', 'c') // Vérifiez que 'categoryId' est le nom de la propriété dans Events.php
            ->addSelect('c');

        // --- Filtre par Catégorie ---
        if ($categoryId !== null && $categoryId > 0) {
            $queryBuilder
                // *** VÉRIFIEZ CECI *** : Assurez-vous que 'e.categoryId' est bien le nom de la
                // propriété de relation ManyToOne vers l'entité Category dans Events.php.
                // Si votre propriété s'appelle $category, utilisez 'e.category'.
                // Doctrine comparera automatiquement l'ID.
                ->andWhere('e.categoryId = :catId')
                ->setParameter('catId', $categoryId);
        }

        // --- Filtrage par Terme de Recherche ---
        $cleanSearchTerm = $searchTerm !== null ? trim($searchTerm) : null;
        if (!empty($cleanSearchTerm)) {
            $queryBuilder
                ->andWhere('LOWER(e.name) LIKE LOWER(:term) OR LOWER(e.description) LIKE LOWER(:term)')
                ->setParameter('term', '%' . $cleanSearchTerm . '%');
        }

        // --- Tri ---
        $queryBuilder->orderBy('e.startTime', 'ASC')
            ->addOrderBy('e.name', 'ASC');

        // Exécute et retourne les résultats
        return $queryBuilder->getQuery()->getResult();
    }
}
