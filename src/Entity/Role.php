<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name:'roles')]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180, unique: true)]
    private string $name;

    #[ORM\Column(length: 180, unique: true)]
    private string $role;

    public function __construct(
        string $name,
        string $role
    ){
        $this->name = $name;
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function update(
        string $name,
        string $role
    ): void {
        $this->name = $name;
        $this->role = $role;
    }
}