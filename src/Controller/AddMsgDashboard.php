<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Repository\ChatRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddMsgDashboard extends AbstractController
{
    private ChatRepository $chatRepository;

    public function __construct(
        ChatRepository $chatRepository,
    ){
        $this->chatRepository = $chatRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/dashboard/add-msg', name: 'dashboard-msg-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $msg = new Chat(
            $request->request->get('userId'),
            $request->request->get('text'),
        );

        $this->chatRepository->save($msg);

        return $this->redirect("/dashboard");
    }
}