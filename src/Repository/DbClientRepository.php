<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DbClientRepository extends ServiceEntityRepository implements ClientRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findById(int $id): ?Client
    {
        return parent::find($id);
    }

    public function findByUserName(string $userName): ?Client
    {
        return parent::find(['userName' => $userName]);
    }

    public function save(Client $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Client $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function findByUser(int $user_id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT clients.*,
                COUNT(o.id) as orders_count,
                SUM(o.sum) as orders_total_amount,
                SUM(o.products) as orders_products
            FROM clients
            JOIN orders o on clients.id = o.client_id
            WHERE user_id=?
            GROUP BY clients.id';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $user_id);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function totalByUser (int $user_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(o.id) as orders_count,
                       SUM(o.products) as products_sum,
                       SUM(o.sum) as orders_sum
        FROM orders AS o
        LEFT JOIN clients c on o.client_id = c.id
        WHERE c.user_id=?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $user_id);

        return $stmt->executeQuery()->fetchAllAssociative();
    }

    public function totalUsers(int $user_id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(c.id) as clients_count
                FROM clients AS c
                WHERE user_id=?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $user_id);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
