<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Afficher les posts dans l'ordre decroissant de la date de publication
     * @param string $codeUe
     * @return \Doctrine\ORM\QueryBuilder
     * 
     * SELECT * 
     * FROM post p
     * WHERE p.codeUE = :codeUe
     * AND p.epingleur IS NULL
     * ORDER BY p.datetimePost DESC;
     */
    public function getPostsSorted(string $codeUe)
    {
        return $this->createQueryBuilder('p')
            ->where('p.codeUE = :codeUe')
            ->andWhere('p.epingleur IS NULL')
            ->setParameter('codeUe', $codeUe)
            ->orderBy('p.datetimePost', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Afficher tous les posts qui sont epingles
     * SELECT * 
     * FROM post p
     * WHERE p.codeUE = :codeUe
     * AND p.epingleur IS NOT NULL
     * ORDER BY p.datetimePost DESC;
     */
    public function getPostsEpingles(string $codeUe)
    {
        return $this->createQueryBuilder('p')
            ->where('p.codeUE = :codeUe')
            ->andWhere('p.epingleur IS NOT NULL')
            ->setParameter('codeUe', $codeUe)
            ->orderBy('p.datetimePost', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
