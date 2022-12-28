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

class Edit extends AbstractController
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
    #[Route('/client/{id}/edit-order', name: 'client-edit-order')]
    public function do(int $id): Response
    {
        $order = $this->orderRepository->find($id);
        $countries = $this->countriesRepository->findAll();
        $statuses = $this->orderStatusRepository->findAll();

        if ($order === null) {
            throw new NotFoundHttpException("order #$id not found");
        }

        return $this->render('order/edit.twig', ['order' => $order,'countries' => $countries,'statuses' => $statuses]);
    }
}