<?php

namespace App\Controller\Clients;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[Route('/client/add', name: 'client-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $client = new Client(
            $request->request->get('userName'),
            $request->request->get('country'),
            $request->request->get('contact'),
        );

        $this->clientRepository->save($client);

        return $this->redirect('/clients/list');
    }
}