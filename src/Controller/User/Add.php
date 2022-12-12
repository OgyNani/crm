<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private  UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/user/add', name: 'user-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $password = $this->passwordHasher->hashPassword(
            new User('a', 2),
            $request->request->get('password')
        );

        $user = new User(
            $request->request->get('userName'),
            $password
        );

        $this->userRepository->save($user, true);

        return $this->redirect('/user/list');
    }
}