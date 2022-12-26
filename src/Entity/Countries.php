<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
#[ORM\Table(name:'countries')]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', length: 2, unique: true)]
    private ?string $id = null;

    #[ORM\Column(name: 'name', length: 180, unique: true)]
    private ?string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function update(
        string $name
    ): void {
        $this->name = $name;
    }
}
