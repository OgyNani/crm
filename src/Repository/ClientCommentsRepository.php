<?php

namespace App\Repository;

use App\Entity\ClientComments;

interface ClientCommentsRepository
{
    public function save(ClientComments $entity): void;
    public function findByClient(int $clientId): array;
}
