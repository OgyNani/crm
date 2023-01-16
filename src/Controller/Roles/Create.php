<?php

namespace App\Controller\Roles;

use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/create', name: 'role-create')]
    public function do(): Response
    {
        return $this->render('roles/create.twig');
    }
}