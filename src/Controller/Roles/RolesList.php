<?php

namespace App\Controller\Roles;

use App\Repository\RoleRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RolesList extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/roles/list', name: 'roles-list')]
    public function do(): Response
    {
        $roles = $this->roleRepository->findAll();
        return $this->render('roles/list.twig', ['roles' => $roles]);
    }
}