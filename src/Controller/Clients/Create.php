<?php

namespace App\Controller\Clients;

use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/create', name: 'client-create')]
    public function do(): Response
    {
        return $this->render('clients/create.twig');
    }
}