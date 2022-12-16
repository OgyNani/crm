<?php

namespace App\Controller\Clients;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    #[Route('/client/create', name: 'client-create')]
    public function do(): Response
    {
        return $this->render('clients/create.twig');
    }
}