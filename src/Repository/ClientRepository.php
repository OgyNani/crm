<?php

namespace App\Repository;

use App\Entity\Client;

interface ClientRepository
{
    public function findById(int $id): ?Client;
    public function findByUserName(string $userName): ?Client;
    public function save(Client $entity): void;
    public function remove(Client $entity): void;
    public function findByUser(int $user_id);
    public function totalByUser(int $user_id);
    public function totalUsers(int $user_id);
}
