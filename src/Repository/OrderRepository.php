<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByClient(int $clientId): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.clientId = :clientId')
            ->setParameter('clientId', $clientId)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countOrdersByClient(int $clientId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.clientId = :clientId')
            ->setParameter('clientId', $clientId)
            ->select('count(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumProductsByClient (int $clientId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.clientId = :clientId')
            ->setParameter('clientId', $clientId)
            ->select('sum(o.products)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumSoldByClient (int $clientId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.clientId = :clientId')
            ->setParameter('clientId', $clientId)
            ->select('sum(o.sum)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function ordersByDate (int $orderId, string $startDate){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT
                    DATE_FORMAT(o.created_at, "%a") AS day,
                    COUNT(o.id) AS `count`
                FROM orders o
                LEFT JOIN clients c on o.client_id = c.id
                WHERE c.user_id=? AND o.created_at >= DATE_SUB(?,INTERVAL 7 DAY)
                GROUP BY day';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$orderId);
        $stmt->bindValue(2,$startDate);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function ordersByMonth (int $orderId, string $fromDate, string $toDate): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT SUM(o.sum) as `sum`,
                YEAR(o.created_at) AS year,
                SUBSTR(MONTHNAME(o.created_at), 1, 3) AS month
                FROM orders o
                LEFT JOIN clients c on o.client_id = c.id
                WHERE c.user_id=? AND o.created_at >= ?  AND o.created_at < ?
                GROUP BY year, month';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$orderId);
        $stmt->bindValue(2, $fromDate);
        $stmt->bindValue(3, $toDate);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function totalOrdersThisWeek (int $orderId){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(o.id) as orders_total
                FROM orders o
                LEFT JOIN clients c on o.client_id = c.id
                WHERE c.user_id=? AND o.created_at >= DATE_SUB(NOW(),INTERVAL 7 DAY)';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$orderId);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function amountThisYear (int $orderId){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT SUM(o.sum) as amount_year
                FROM orders o
                LEFT JOIN clients c on o.client_id = c.id
                WHERE c.user_id=? AND o.created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1,$orderId);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

}
