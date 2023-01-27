<?php

namespace App\Controller\Clients;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/add', name: 'client-add', methods: ['POST'])]
    public function do(AddRequest $request): Response
    {
        $errors = $request->validate();

        if (!empty($errors)) {
            return $this->render('clients/create.twig', ['errors' => $errors]);
        }

        $client = new Client(
            $request->userId,
            $request->userName,
            $request->country,
            $request->contact,
        );

        $this->clientRepository->save($client);

        return $this->redirect('/clients/list');
    }
}