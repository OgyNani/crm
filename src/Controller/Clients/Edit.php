<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[Route('/client/{id}/edit', name: 'client-edit')]
    public function do(int $id): Response
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            throw new NotFoundHttpException("client #$id not found");
        }

        return $this->render('clients/edit.twig', ['client' => $client]);
    }
}