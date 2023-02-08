<?php

namespace App\Controller\Roles;

use App\Repository\PermissionRepository;
use App\Repository\ResourcesRepository;
use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RolesList extends AbstractController
{
    private RoleRepository $roleRepository;
    private PermissionRepository $permissionRepository;
    private ResourcesRepository $resourcesRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
        ResourcesRepository $resourcesRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->resourcesRepository = $resourcesRepository;

    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/roles/list', name: 'roles-list')]
    public function do(): Response
    {
        $roles = $this->roleRepository->findAll();
        $permissions = $this->permissionRepository->findAll();
        $resources = $this->resourcesRepository->findAll();
        return $this->render(
            'roles/list.twig',
            [
                'roles' => $roles,
                'permissions' => $permissions,
                'resources' => $resources
            ]
        );
    }
}