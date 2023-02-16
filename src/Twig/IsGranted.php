<?php

namespace App\Twig;

use App\Repository\PermissionRepository;
use App\Repository\ResourcesRepository;
use App\Repository\RoleRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class IsGranted extends AbstractExtension
{
    private Security $security;
    private RoleRepository $roleRepository;
    private ResourcesRepository $resourcesRepository;
    private PermissionRepository $permissionRepository;

    public function __construct(
        Security $security,
        RoleRepository $roleRepository,
        ResourcesRepository $resourcesRepository,
        PermissionRepository $permissionRepository
    ) {
        $this->security = $security;
        $this->roleRepository = $roleRepository;
        $this->resourcesRepository = $resourcesRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('is_granted', array($this, 'check')),
        );
    }

    public function check(string $resource, string $access)
    {
        $user = $this->security->getUser();

        if ($user === null) {
            return false;
        }

        $role = $this->roleRepository->find($user->getRoleId());

        if ($role === null) {
            return false;
        }

        if ($role->getName() === 'Admin') {
            return true;
        }

        $resource = $this->resourcesRepository->findByName($resource);

        if ($resource === null) {
            return false;
        }

        $permission = $this->permissionRepository->check($role->getId(), $resource->getId(), $access);

        if ($permission === null) {
            return false;
        }

        return true;
    }
}
