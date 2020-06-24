<?php

namespace App\Repository;

use App\Entity\Totem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Totem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Totem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Totem[]    findAll()
 * @method Totem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TotemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Totem::class);
    }

    // /**
    //  * @return Totem[] Returns an array of Totem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Totem
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
