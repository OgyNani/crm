<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Save extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/{id}/save', name: 'client-save', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        $clients = $this->clientRepository->find($id);

        if ($clients === null) {
            throw new NotFoundHttpException("Client #$id not found");
        }

        $clients->update(
            $request->request->get('userName'),
            $request->request->get('country'),
            $request->request->get('contact')
        );
        $this->clientRepository->save($clients);

        return $this->redirect("/client/{$id}/profile");
    }
}