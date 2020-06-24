<?php

namespace App\Repository;

use App\Entity\OverValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OverValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method OverValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method OverValue[]    findAll()
 * @method OverValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OverValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OverValue::class);
    }

    // /**
    //  * @return OverValue[] Returns an array of OverValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OverValue
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
