<?php

namespace App\Controller\Roles;

use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ){
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/add', name: 'role-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $role = new Role(
            $request->request->get('name'),
            $request->request->get('role')
        );

        $this->roleRepository->save($role);

        return $this->redirect('/roles/list');
    }
}