<?php

namespace App\Controller\Roles;

use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class Delete extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/delete', name:'role-delete')]
    public function do(int $id): Response
    {
        $role = $this->roleRepository->find($id);

        if ($role === null) {
            throw new NotFoundHttpException("Role #$id not found");
        }

        $this->roleRepository->remove($role);

        return $this->redirect('/roles/list');
    }

    public function get()
    {
        // TODO: Implement get() method.
    }
}