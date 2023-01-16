<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsList extends AbstractController
{
    private Security $security;
    private ClientRepository $clientRepository;

    public function __construct(Security $security, ClientRepository $clientRepository)
    {
        $this->security = $security;
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/clients/list', name: 'clients-list')]
    public function do(): Response
    {
        $clients = $this->clientRepository->findBy(['userId' => $this->security->getUser()->getId()]);
        return $this->render('clients/list.twig', ['clients' => $clients]);
    }
}