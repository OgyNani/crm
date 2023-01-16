<?php

namespace App\Controller\Orders;

use App\Repository\CountriesRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/order/{id}/save', name: 'order-save', methods: ['POST'])]
    public function do(int $id, AddRequest $request): Response
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            throw new NotFoundHttpException("Order #$id not found");
        }

        $errors = $request->validate();
        if (!empty($errors)) {
            $countries = $this->countriesRepository->findAll();
            $statuses = $this->orderStatusRepository->findAll();

            return $this->render(
                'order/edit.twig',
                [
                    'clientId' => $request->clientId,
                    'orderId' => $request->orderId,
                    'products' => $request->orderProducts,
                    'country' => $request->country,
                    'countries' => $countries,
                    'sum' => $request->orderSum,
                    'statuses' => $statuses,
                    'errors' => $errors,
                    'order' => $order,
                ]
            );
        }

        $order->update(
            $request->orderId,
            $request->orderProducts,
            $request->country,
            $request->orderSum,
            $request->status
        );
        $this->orderRepository->save($order);


        return $this->redirect("/client/{$order->getClientId()}/profile");
    }
}