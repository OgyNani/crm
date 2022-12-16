<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class Delete extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/user/{id}/delete', name:'user-delete')]
    public function do(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            throw new NotFoundHttpException("User #$id not found");
        }

        $this->userRepository->remove($user);

        return $this->redirect('/user/list');
    }
}