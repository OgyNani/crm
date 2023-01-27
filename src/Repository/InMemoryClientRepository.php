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
}