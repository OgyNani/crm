<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class Delete extends AbstractController
{
    private  ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/{id}/delete', name:'client-delete')]
    public function do(int $id): Response
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            throw new NotFoundHttpException("Client #$id not found");
        }

        $this->clientRepository->remove($client);

        return $this->redirect('/clients/list');
    }
}