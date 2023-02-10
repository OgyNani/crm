<?php

namespace App\Repository;

use App\Entity\OrderComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderComments>
 *
 * @method OrderComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderComments[]    findAll()
 * @method OrderComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DbOrderCommentsRepository extends ServiceEntityRepository implements OrderCommentsRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderComments::class);
    }

    public function save(OrderComments $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findByOrder(int $orderId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT order_comments.*,
                    u.username as comment_creator
                FROM order_comments
                JOIN user u on order_comments.user_id = u.id
                WHERE order_comments.order_id=?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $orderId);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
}