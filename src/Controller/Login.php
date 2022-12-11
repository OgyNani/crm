<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Login extends AbstractController
{
    #[Route('/', name: 'login')]
    public function do(): Response
    {
        return $this->render('login.twig');
    }

    #[Route('/login/submit', name: 'login-submit')]
    public function submit(): Response
    {
        // login
        return $this->render('login.twig');
    }
}