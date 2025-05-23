<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
// use Doctrine\ORM\QueryBuilder; // Cette ligne n'est pas nécessaire si tu ne l'utilises pas pour typer

/**
 * @extends ServiceEntityRepository<Album>
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     *
     * @param string|null $searchTerm La chaîne de recherche (titre de l'album ou nom de l'artiste).
     * @param int|null $genreId L'ID du genre.
     * @param int|null $year L'année de sortie.
     * @return Album[]
     */
    public function findFilteredAlbums(?string $searchTerm, ?int $genreId, ?int $year): array
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.genres', 'g') // Erreur ici qui posait problème (mauvais nommage)
            ->addSelect('g')
            ->leftJoin('a.band', 'b')
            ->addSelect('b');

        if ($searchTerm) {
            $qb->andWhere(
                $qb->expr()->like('a.title', ':search') . ' OR ' .
                    $qb->expr()->like('b.name', ':search')
            )
                ->setParameter('search', '%' . $searchTerm . '%');
        }

        if ($genreId) {
            $qb->andWhere('g.id = :genreId')
                ->setParameter('genreId', $genreId);
        }

        if ($year) {
            $start = new \DateTimeImmutable("$year-01-01 00:00:00");
            $end = $start->modify('+1 year');

            $qb->andWhere('a.releaseDate >= :start')
                ->andWhere('a.releaseDate < :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end);
        }

        $qb->orderBy('a.releaseDate', 'DESC') // Randem
            ->addOrderBy('a.title', 'ASC');

        return $qb->getQuery()->getResult();
    }
}

//    /**
//     * @return Album[] Returns an array of Album objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Album
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
