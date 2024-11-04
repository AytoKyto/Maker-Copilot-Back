<?php

namespace App\Repository;

use App\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 *
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    /**
     * @return Sale[] Returns an array of Sale objects
     */
    public function findSalesProductBetweenDate($startDate, $endDate, $userId): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.salesProducts', 'sp')
            ->andWhere('s.createdAt >= :startDate')
            ->andWhere('s.createdAt <= :endDate')
            ->andWhere('s.user = :userId')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->orderBy('s.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Sale[] Returns an array of Sale objects
     */
    public function getTopProductSaleBetweenDate($startDate, $endDate, $userId): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select([
                'IDENTITY(sp.product) AS product_id',
                'p.name AS product_name',
                'COUNT(sp.product) AS nb_product',
                'SUM(price.price) AS sumPrice',
                'SUM(price.benefit) AS sumBenefit',
                'SUM(price.commission) AS sumCommission',
                'SUM(price.time) AS sumTime'
            ])
            ->join('s.salesProducts', 'sp')
            ->join('sp.price', 'price')
            ->join('sp.product', 'p')
            ->andWhere('s.createdAt >= :startDate')
            ->andWhere('s.createdAt <= :endDate')
            ->andWhere('s.user = :userId')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->groupBy('product_id')
            ->orderBy('nb_product', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Sale[] Returns an array of Sale objects
     */
    public function getTopCanalSaleBetweenDate($startDate, $endDate, $userId): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select([
                'IDENTITY(s.canal) AS canal_id',
                'c.name AS canal_name',
                'COUNT(sp.product) AS nb_product',
                'SUM(price.price) AS sumPrice',
                'SUM(price.benefit) AS sumBenefit',
                'SUM(price.commission) AS sumCommission',
                'SUM(price.time) AS sumTime'
            ])
            ->join('s.salesProducts', 'sp')
            ->join('sp.price', 'price')
            ->join('sp.product', 'p')
            ->join('s.canal', 'c')
            ->andWhere('s.createdAt >= :startDate')
            ->andWhere('s.createdAt <= :endDate')
            ->andWhere('s.user = :userId')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->groupBy('canal_id')
            ->orderBy('nb_product', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getTopClientSaleBetweenDate($startDate, $endDate, $userId): array
    {
        $qb = $this->createQueryBuilder('s')
            ->select([
                'IDENTITY(sp.client) AS client_id',
                'c.name AS client_name',
                'COUNT(sp.product) AS nb_product',
                'SUM(price.price) AS sumPrice',
                'SUM(price.benefit) AS sumBenefit',
                'SUM(price.commission) AS sumCommission',
                'SUM(price.time) AS sumTime'
            ])
            ->join('s.salesProducts', 'sp')
            ->join('sp.price', 'price')
            ->join('sp.product', 'p')
            ->join('sp.client', 'c')
            ->andWhere('s.createdAt >= :startDate')
            ->andWhere('s.createdAt <= :endDate')
            ->andWhere('s.user = :userId')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->groupBy('client_id')
            ->orderBy('nb_product', 'DESC');

        return $qb->getQuery()->getResult();
    }
}