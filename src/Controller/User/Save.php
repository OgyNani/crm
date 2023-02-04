<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class Save extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    #[IsPermissionGranted(resource: 'users', access: 'manage')]
    #[Route('/user/{id}/save', name: 'user-save', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            throw new NotFoundHttpException("User #$id not found");
        }

        $user->update(
            $request->request->get('userName')
        );

        $user->updateRole(
            $request->request->get('roleId')
        );

        if ($request->request->get('password') !== '') {
            $password = $this->passwordHasher->hashPassword(
                new User('a', 2, 2),
                $request->request->get('password')
            );

            $user->updatePassword($password);
        }

        $this->userRepository->save($user);

        return $this->redirect("/user/{$id}/profile");
    }
}