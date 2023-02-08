<?php

namespace App\Controller\Roles;

use App\Repository\ResourcesRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SavePermission extends AbstractController
{
    private ResourcesRepository $resourcesRepository;

    public function __construct(
        ResourcesRepository $resourcesRepository
    ) {
        $this->resourcesRepository = $resourcesRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/role/{id}/save-permission', name: 'role-save-permission', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        // save
    }
}