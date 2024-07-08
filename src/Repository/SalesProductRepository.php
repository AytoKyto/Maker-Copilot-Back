<?php

namespace App\Repository;

use App\Entity\SalesProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalesProduct>
 *
 * @method SalesProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesProduct[]    findAll()
 * @method SalesProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesProduct::class);
    }

//    /**
//     * @return SalesProduct[] Returns an array of SalesProduct objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalesProduct
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
