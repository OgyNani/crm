<?php

namespace App\Controller\Clients;

use App\Repository\ClientCommentsRepository;
use App\Repository\ClientRepository;
use App\Repository\CountriesRepository;
use App\Repository\OrderRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Profile extends AbstractController
{
    private ClientRepository $clientRepository;
    private OrderRepository $orderRepository;
    private CountriesRepository $countriesRepository;
    private ClientCommentsRepository $clientCommentsRepository;

    public function __construct(ClientRepository $clientRepository,
                                OrderRepository $orderRepository,
                                CountriesRepository $countriesRepository,
                                ClientCommentsRepository $clientCommentsRepository
    )
    {
        $this->clientRepository = $clientRepository;
        $this->orderRepository = $orderRepository;
        $this->countriesRepository = $countriesRepository;
        $this->clientCommentsRepository = $clientCommentsRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/client/{id}/profile', name: 'client-profile')]
    public function do(int $id): Response
    {
        $client = $this->clientRepository->findById($id);

        if ($client === null) {
            throw new NotFoundHttpException("client #$id not found");
        }

        $orders = $this->orderRepository->findByClient($id);
        $countries = $this->countriesRepository->findAll();
        $ordersCount = $this->orderRepository->countOrdersByClient($id);
        $productsSum = $this->orderRepository->sumProductsByClient($id);
        $totalSum = $this->orderRepository->sumSoldByClient($id);
        $commentsData = $this->clientCommentsRepository->findByClient($id);

        return $this->render('clients/profile.twig', [
            'client' => $client,
            'orders' => $orders,
            'countries' => $countries,
            'ordersCount' => $ordersCount,
            'productsSum' => $productsSum,
            'totalSum' => $totalSum,
            'commentsData' => $commentsData,
        ]);
    }
}