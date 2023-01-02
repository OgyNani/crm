<?php

namespace App\Controller\Orders;

use App\Entity\Order;
use App\Repository\CountriesRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private OrderRepository $orderRepository;
    private CountriesRepository $countriesRepository;
    private OrderStatusRepository $orderStatusRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CountriesRepository $countriesRepository,
        OrderStatusRepository $orderStatusRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->countriesRepository = $countriesRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/order/add', name: 'order-add', methods: ['POST'])]
    public function do(AddRequest $request): Response
    {
        $errors = $request->validate();
        if (!empty($errors)) {
            $countries = $this->countriesRepository->findAll();
            $statuses = $this->orderStatusRepository->findAll();

            return $this->render(
                'order/create.twig',
                [
                    'clientId' => $request->clientId,
                    'orderId' =>$request->orderId,
                    'products' => $request->orderProducts,
                    'countries' => $countries,
                    'sum' => $request->orderSum,
                    'statuses' => $statuses,
                    'errors' => $errors,
                ]
            );
        }

        $order = new Order(
            $request->orderId,
            $request->clientId,
            $request->orderProducts,
            $request->country,
            $request->orderSum,
            $request->status
        );

        $this->orderRepository->save($order);

        return $this->redirect("/client/{$order->getClientId()}/profile");
    }
}