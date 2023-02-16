<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
#[ORM\Table(name:'chat')]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'user_id', type: 'integer')]
    private int $userId;

    #[ORM\Column(name: 'creation_at', type: 'datetime')]
    private \DateTime $creationAt;

    #[ORM\Column(length: 255, unique: true)]
    private string $text;

    public function __construct(
        int $userId,
        string $text
    ) {
        $this->userId = $userId;
        $this->creationAt = new \DateTime();
        $this->text = $text;
    }

    public function getId(): ?int
    {
        return $this->id;
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
