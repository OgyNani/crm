<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[IsPermissionGranted(resource: 'users', access: 'manage')]
    #[Route('/user/{id}/edit', name: 'user-edit')]
    public function do(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            throw new NotFoundHttpException("User #$id not found");
        }

        return $this->render('user/edit.twig', ['user' => $user]);
    }
}