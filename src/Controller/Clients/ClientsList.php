<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsList extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/clients/list', name: 'clients-list')]
    public function do(): Response
    {
        $clients = $this->clientRepository->findAll();
        return $this->render('clients/list.twig', ['clients' => $clients]);
    }
}