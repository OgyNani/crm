<?php

namespace App\Repository;

use App\Entity\Client;

interface ClientRepository
{
    public function findByUserName(string $userName): ?Client;
    public function save(Client $entity): void;
    public function remove(Client $entity): void;
    public function findByUser(int $userId): array;
}
