<?php

namespace App\Security;

use App\Repository\PermissionRepository;
use App\Repository\ResourcesRepository;
use App\Repository\RoleRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PermissionVoter extends Voter
{
    private RoleRepository $roleRepository;
    private ResourcesRepository $resourcesRepository;
    private PermissionRepository $permissionRepository;

    public function __construct(
        RoleRepository $roleRepository,
        ResourcesRepository $resourcesRepository,
        PermissionRepository $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->resourcesRepository = $resourcesRepository;
        $this->permissionRepository = $permissionRepository;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

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

        $resource = $this->resourcesRepository->findByName($subject);

        if ($resource === null) {
            return false;
        }

        $permission = $this->permissionRepository->check($role->getId(), $resource->getId(), $attribute);

        if ($permission === null) {
            return false;
        }

        return true;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return true;
    }
}