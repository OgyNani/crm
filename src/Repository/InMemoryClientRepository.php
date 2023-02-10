<?php

namespace App\Repository;

use App\Entity\Client;

class InMemoryClientRepository implements ClientRepository
{
    private array $clients = [];

    public function findById(int $id): ?Client
    {
        return $this->clients[$id] ?? null;
    }

    public function findByUserName(string $userName): ?Client
    {
        return $this->clients[$userName] ?? null;
    }

    public function save(Client $entity): void
    {
        $this->clients[$entity->getId()] = $entity;
    }

    public function remove(Client $entity): void
    {
        unset($this->clients[$entity->getId()]);
    }
}