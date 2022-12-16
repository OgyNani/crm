<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
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

    #[Route('/clients/list', name: 'clients-list')]
    public function do(): Response
    {
        $clients = $this->clientRepository->findAll();
        return $this->render('clients/list.twig', ['clients' => $clients]);
    }
}