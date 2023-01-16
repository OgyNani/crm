<?php

namespace App\Controller\User;

use App\Repository\ClientRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Profile extends AbstractController
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;
    private ClientRepository $clientRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        ClientRepository $clientRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'users', access: 'view')]
    #[Route('/user/{id}/profile', name: 'user-profile', requirements: ['id' => '\d+'])]
    public function do(int $id): Response
    {
        $user = $this->userRepository->find($id);
        $role = $this->roleRepository->find($user->getRoleId());
        $roles = $this->roleRepository->findAll();
        return $this->render(
            'user/profile.twig',
            ['user' => $user, 'role' => $role, 'roles' => $roles]
        );
    }
}