<?php

namespace App\Repository;

use App\Entity\ClientComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClientComments>
 *
 * @method ClientComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientComments[]    findAll()
 * @method ClientComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DbClientCommentsRepository extends ServiceEntityRepository implements ClientCommentsRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientComments::class);
    }

    public function save(ClientComments $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public  function findByClient(int $clientId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT client_comments.*,
                    u.username as comment_creator
                FROM client_comments
                JOIN user u on client_comments.user_id = u.id
                WHERE client_comments.client_id=?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $clientId);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
