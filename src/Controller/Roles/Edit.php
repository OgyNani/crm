<?php

namespace App\Controller\Roles;

use App\Repository\PermissionRepository;
use App\Repository\ResourcesRepository;
use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
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

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/edit', name: 'role-edit')]
    public function do(int $id): Response
    {
        $role = $this->roleRepository->find($id);

        if ($role === null) {
            throw new NotFoundHttpException("Role #$id not found");
        }

        $resources = $this->resourcesRepository->findAll();

        $permissions = $this->permissionRepository->findByRole($id);

        $permissionsData = [];
        foreach ($permissions as $permission) {
            $permissionsData[$permission->getResourceId()][$permission->getAccess()] = 1;
        }

        return $this->render(
            'roles/edit.twig',
            [
                'role' => $role,
                'resources' => $resources,
                'permissions' => $permissionsData,
            ]
        );
    }
}