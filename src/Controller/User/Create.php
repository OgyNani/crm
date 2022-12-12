<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    #[Route('/user/create', name: 'user-create')]
    public function do(): Response
    {
        return $this->render('user/create.twig');
    }
}