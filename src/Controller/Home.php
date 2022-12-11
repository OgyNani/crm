<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Home extends AbstractController
{
    #[Route('/', name: 'home')]
    public function do(): Response
    {
        $number = random_int(0, 999999);

        return $this->render('home.twig', ['products' => []]);
    }
}