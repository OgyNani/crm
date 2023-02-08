<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ORM\Table(name:'permissions')]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'role_id')]
    private int $roleId;

    #[ORM\Column(name: 'resource_id')]
    private int $resourceId;

    #[ORM\Column()]
    private string $access;

    public function __construct(
        int $roleId,
        int $resourceId,
        string $access
    ){
        $this->roleId = $roleId;
        $this->resourceId = $resourceId;
        $this->access = $access;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getResourceId(): int
    {
        return $this->resourceId;
    }

    public function getAccess(): string
    {
        return $this->access;
    }
}