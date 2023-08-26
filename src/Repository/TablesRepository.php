<?php

namespace App\Repository;

use App\Entity\Tables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tables>
 *
 * @method Tables|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tables|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tables[]    findAll()
 * @method Tables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tables::class);
    }

    public function findTableGuests($value): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.tables = :val')
            ->setParameter('val', $value)
            ->leftJoin("t.tables", "cover")
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Tabels
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
