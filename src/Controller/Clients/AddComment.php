<?php

namespace App\Controller\Clients;

use App\Entity\ClientComments;
use App\Repository\ClientCommentsRepository;
use App\Repository\ClientRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddComment extends AbstractController
{
    private ClientCommentsRepository $clientCommentsRepository;
    private ClientRepository $clientRepository;

    public function __construct(
        ClientCommentsRepository $clientCommentsRepository,
        ClientRepository $clientRepository
    ){
        $this->clientCommentsRepository = $clientCommentsRepository;
        $this->clientRepository = $clientRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/{id}/add-comment', name: 'client-comment-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $comment = new ClientComments(
            $request->request->get('clientId'),
            $request->request->get('userId'),
            $request->request->get('text'),
        );

        $this->clientCommentsRepository->save($comment);

        return $this->redirect("/client/{$comment->getClientId()}/profile");
    }
}