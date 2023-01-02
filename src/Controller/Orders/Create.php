<?php

namespace App\Controller\Orders;

use App\Repository\CountriesRepository;
use App\Repository\OrderStatusRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    private CountriesRepository $countriesRepository;
    private OrderStatusRepository $orderStatusRepository;

    public function __construct(
        CountriesRepository $countriesRepository,
        OrderStatusRepository $orderStatusRepository
    ) {
        $this->countriesRepository = $countriesRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/{clientId}/new-order', name: 'client-new-order')]
    public function do(int $clientId): Response
    {
        $countries = $this->countriesRepository->findAll();
        $statuses = $this->orderStatusRepository->findAll();
        return $this->render(
            'order/create.twig',
            ['clientId' => $clientId, 'countries' => $countries, 'statuses' => $statuses, 'errors' => []]
        );
    }
}