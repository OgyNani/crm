<?php

namespace App\Controller\Roles;

use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Save extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/save', name: 'role-save', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        $roles = $this->roleRepository->find($id);

        if ($roles === null) {
            throw new NotFoundHttpException("Role #$id not found");
        }

        $roles->update(
            $request->request->get('name'),
            $request->request->get('role')
        );
        $this->roleRepository->save($roles);


        return $this->redirect("/roles/list");
    }
}