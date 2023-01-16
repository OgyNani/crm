<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name:'clients')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $userId;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $contact = null;

    public function __construct(
        int $userId,
        string $username,
        string $country,
        string $contact
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->country = $country;
        $this->contact = $contact;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function update(
        string $userName,
        string $country,
        string $contact
    ): void {
        $this->username = $userName;
        $this->country = $country;
        $this->contact = $contact;
    }
}
