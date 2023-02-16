<?php

namespace App\Controller\Roles;

use App\Entity\Permission;
use App\Repository\PermissionRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SavePermission extends AbstractController
{
    private PermissionRepository $permissionRepository;

    public function __construct(
        PermissionRepository $resourcesRepository
    ) {
        $this->permissionRepository = $resourcesRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/save-permission', name: 'role-save-permission', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        $permission = $this->permissionRepository->check(
            $id,
            $request->get('resourceId'),
            $request->get('access')
        );

        if ($permission !== null) {
            $this->permissionRepository->remove($permission);
            return new JsonResponse(['status' => 'ok']);
        }

        $permission = new Permission(
            $id,
            $request->get('resourceId'),
            $request->get('access')
        );

        $this->permissionRepository->save($permission);

        return new JsonResponse(['status' => 'ok']);
    }
}