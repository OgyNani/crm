<?php

namespace App\Entity;

use App\Repository\ResourcesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourcesRepository::class)]
#[ORM\Table(name:'resources')]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 180, unique: true)]
    private string $name;

    #[ORM\Column(name:'available_accesses', length: 180, unique: true)]
    private string $availableAccess;

    public function __construct(string $name, string $availableAccess)
    {
        $this->name = $name;
        $this->availableAccess = $availableAccess;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvailableAccess(): array
    {
        return explode(',', $this->availableAccess);
    }
}