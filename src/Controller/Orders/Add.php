<?php

namespace App\Controller\Orders;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private OrderRepository $orderRepository;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/order/add', name: 'order-add', methods: ['POST'])]
    public function do(Request $request): Response
    {
        $order = new Order(
            $request->request->get('orderId'),
            $request->request->get('clientId'),
            $request->request->get('orderProducts'),
            $request->request->get('country'),
            $request->request->get('orderSum'),
            $request->request->get('status')
        );

        $this->orderRepository->save($order);

        return $this->redirect("/client/{$order->getClientId()}/profile");
    }
}