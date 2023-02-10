<?php

namespace App\Repository;

use App\Entity\OrderComments;

interface OrderCommentsRepository
{
    public function save(OrderComments $entity): void;
    public function findByOrder(int $orderId): array;
}
