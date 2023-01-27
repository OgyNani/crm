<?php

namespace App\Controller\Clients;

use App\Repository\CountriesRepository;
use App\Security\IsPermissionGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Create extends AbstractController
{
    private CountriesRepository $countriesRepository;

    public function __construct(CountriesRepository $countriesRepository)
    {
        $this->countriesRepository = $countriesRepository;
    }

    #[IsPermissionGranted(resource: 'clients', access: 'manage')]
    #[Route('/client/create', name: 'client-create')]
    public function do(): Response
    {
        $countries = $this->countriesRepository->findAll();

        return $this->render('clients/create.twig', ['countries' => $countries]);
    }
}