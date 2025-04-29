<?php

namespace App\Repository;

use App\Entity\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actualite>
 */
class ActualiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualite::class);
    }
    public function findByUes($ues): array
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.codeUE IN (:ues)')
        ->setParameter('ues', $ues)
        ->orderBy('a.datetimeAct', 'DESC')
        ->getQuery()
        ->getResult();
}

}
