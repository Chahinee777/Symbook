<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/home', name: 'index')]
    public function commande(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/home', name: 'index2')]
    public function commande2(): Response
    {
        return $this->render('commande/index2.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
