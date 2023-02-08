<?php

namespace App\Repository;

use App\Entity\Client;

class InMemoryClientRepository implements ClientRepository
{
    private array $clients = [];

    public function findByUserName(string $userName): ?Client
    {
        return $this->clients[$userName] ?? null;
    }

    public function save(Client $entity): void
    {
        $this->clients[$entity->getUsername()] = $entity;
    }

    public function remove(Client $entity): void
    {
        unset($this->clients[$entity->getUsername()]);
    }

    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.userId = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}