<?php

namespace App\Repository;

use App\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permission>
 *
 * @method Permission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permission[]    findAll()
 * @method Permission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function save(Permission $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Permission $permission): void
    {
        $this->getEntityManager()->remove($permission);
        $this->getEntityManager()->flush();
    }

    public function check(int $roleId, int $resourceId, string $access): ?Permission
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.roleId = :roleId')
            ->andWhere('r.resourceId = :resourceId')
            ->andWhere('r.access = :access')
            ->setParameter('roleId', $roleId)
            ->setParameter('resourceId', $resourceId)
            ->setParameter('access', $access)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $roleId
     * @return Permission[]
     */
    public function findByRole(int $roleId): array
    {
        return $this->findBy(['roleId' => $roleId]);
    }
}
