<?php

namespace App\Controller\Orders;

use App\Repository\CountriesRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class Save extends AbstractController
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

    #[Route('/order/{id}/save', name: 'order-save', methods: ['POST'])]
    public function do(int $id, Request $request): Response
    {
        $orders = $this->orderRepository->find($id);

        if ($orders === null) {
            throw new NotFoundHttpException("Order #$id not found");
        }

        $orders->update(
            $request->request->get('orderId'),
            $request->request->get('orderProducts'),
            $request->request->get('country'),
            $request->request->get('orderSum'),
            $request->request->get('status')
        );
        $this->orderRepository->save($orders);


        return $this->redirect("/client/{$orders->getClientId()}/profile");
    }
}