<?php

namespace App\Controller\Roles;

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

    public function __construct(
        RoleRepository $roleRepository,
        ResourcesRepository $resourcesRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->resourcesRepository = $resourcesRepository;
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

        return $this->render('roles/edit.twig', ['role' => $role, 'resources' => $resources]);
    }
}