<?php

namespace App\Entity;

use App\Repository\OrderCommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderCommentsRepository::class)]
#[ORM\Table(name:'order_comments')]
class OrderComments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'order_id', type: 'integer')]
    private int $orderId;

    #[ORM\Column(name: 'user_id', type: 'integer')]
    private int $userId;

    #[ORM\Column(name: 'creation_at', type: 'datetime')]
    private \DateTime $creationAt;

    #[ORM\Column(length: 255)]
    private string $text;

    public function __construct(
        int $orderId,
        int $userId,
        string $text
    ) {
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->creationAt = new \DateTime();
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreationAt(): \DateTime
    {
        return $this->creationAt;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}