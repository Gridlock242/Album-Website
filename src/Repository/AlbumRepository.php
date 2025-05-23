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
     * Retourne les albums filtrés par recherche libre, genre et année.
     *
     * @param string|null $searchTerm La chaîne de recherche (titre de l'album ou nom de l'artiste).
     * @param int|null $genreId L'ID du genre.
     * @param int|null $year L'année de sortie.
     * @return Album[]
     */
    public function findFilteredAlbums(?string $searchTerm, ?int $genreId, ?int $year): array
    {
        $qb = $this->createQueryBuilder('a')
            // Changer 'a.genre' en 'a.genres' ici !
            ->leftJoin('a.genres', 'g') // <-- Correction ici : 'genres' au pluriel
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
            // Puisque c'est une relation ManyToMany, tu dois vérifier si 'g.id' est dans la collection 'genres' de l'album
            // ou si l'album a un genre avec cet ID.
            // La façon actuelle (g.id = :genreId) est correcte si 'g' est l'alias du genre dans la jointure.
            $qb->andWhere('g.id = :genreId')
                ->setParameter('genreId', $genreId);
        }

        // Si 'releaseDate' est un DateTime et tu veux filtrer par année
        if ($year) {
            $qb->andWhere('YEAR(a.releaseDate) = :year')
                ->setParameter('year', $year);
        }

        $qb->orderBy('a.releaseDate', 'DESC') // Ordre par date de sortie
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

