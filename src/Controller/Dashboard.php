<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Dashboard extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function do(): Response
    {
        return $this->render('dashboard.twig');
    }
}