<?php

namespace App\Controller\Clients;

use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Profile extends AbstractController
{
    private ClientRepository $clientRepository;
    private OrderRepository $orderRepository;

    public function __construct(ClientRepository $clientRepository, OrderRepository $orderRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->orderRepository = $orderRepository;
    }

    #[Route('/client/{id}/profile', name: 'client-profile')]
    public function do(int $id): Response
    {
        $client = $this->clientRepository->find($id);
        $orders = $this->orderRepository->findByClient($id);

        if ($client === null) {
            throw new NotFoundHttpException("client #$id not found");
        } elseif ($orders === null) {
            throw new NotFoundHttpException("orders #$id not found");
        }

        return $this->render('clients/profile.twig', ['client' => $client, 'orders' => $orders]);
    }
}