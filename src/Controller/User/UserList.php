<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserList extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[IsPermissionGranted(resource: 'users', access: 'manage')]
    #[Route('/user/list', name: 'user-list')]
    public function do(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('user/list.twig', ['users' => $users]);
    }
}