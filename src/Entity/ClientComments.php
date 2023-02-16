<?php

namespace App\Entity;

use App\Repository\ClientCommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientCommentsRepository::class)]
#[ORM\Table(name:'client_comments')]
class ClientComments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'client_id', type: 'integer')]
    private int $clientId;

    #[ORM\Column(name: 'user_id', type: 'integer')]
    private int $userId;

    #[ORM\Column(name: 'creation_at', type: 'datetime')]
    private \DateTime $creationAt;

    #[ORM\Column(length: 255, unique: true)]
    private string $text;

    public function __construct(
        int $clientId,
        int $userId,
        string $text
    ) {
        $this->clientId = $clientId;
        $this->userId = $userId;
        $this->creationAt = new \DateTime();
        $this->text = $text;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
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
