<?php

namespace App\Repository;

use App\Entity\Chat;

interface ChatRepository
{
    public function save(Chat $entity): void;
    public function showMsg();
}
