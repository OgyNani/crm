<?php

namespace App\Controller\User;

use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct (RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[IsPermissionGranted(resource: 'users', access: 'manage')]
    #[Route('/user/create', name: 'user-create')]
    public function do(): Response
    {
        $roles = $this->roleRepository->findAll();

        return $this->render('user/create.twig', ['roles' => $roles]);
    }
}