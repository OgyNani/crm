<?php

namespace App\Controller\Roles;

use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/edit', name: 'role-edit')]
    public function do(int $id): Response
    {
        $role = $this->roleRepository->find($id);

        if ($role === null) {
            throw new NotFoundHttpException("Role #$id not found");
        }

        return $this->render('roles/edit.twig', ['role' => $role]);
    }
}