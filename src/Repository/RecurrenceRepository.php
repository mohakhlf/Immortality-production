<?php

namespace App\Repository;

use App\Entity\Recurrence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recurrence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recurrence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recurrence[]    findAll()
 * @method Recurrence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecurrenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recurrence::class);
    }

    // /**
    //  * @return Recurrence[] Returns an array of Recurrence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recurrence
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
