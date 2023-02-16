<?php

namespace App\Controller\Orders;

use App\Repository\ClientRepository;
use App\Repository\CountriesRepository;
use App\Repository\OrderCommentsRepository;
use App\Repository\OrderRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Comments extends AbstractController
{
    private ClientRepository $clientRepository;
    private OrderRepository $orderRepository;
    private CountriesRepository $countriesRepository;
    private OrderCommentsRepository $orderCommentsRepository;

    public function __construct(
        ClientRepository $clientRepository,
        OrderRepository $orderRepository,
        CountriesRepository $countriesRepository,
        OrderCommentsRepository $orderCommentsRepository
    ){
        $this->clientRepository = $clientRepository;
        $this->orderRepository = $orderRepository;
        $this->countriesRepository = $countriesRepository;
        $this->orderCommentsRepository = $orderCommentsRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'view')]
    #[Route('/client/{id}/order-comments', name: 'order-comments')]
    public function do(int $id): Response
    {
        $client = $this->clientRepository->findById($id);
        $order = $this->orderRepository->find($id);
        $countries = $this->countriesRepository->findAll();
        $commentsData = $this->orderCommentsRepository->findByOrder($id);
        return $this->render('order/comments.twig',
        [
            'client' => $client,
            'order' => $order,
            'countries' => $countries,
            'commentsData' => $commentsData
        ]);
    }
}