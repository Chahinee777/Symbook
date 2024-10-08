<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{

    #[Route('/payment', name: 'payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout/{id}', name: 'checkout')]
    public function checkout(int $id, EntityManagerInterface $em): Response
    {
        $order = $em->getRepository(Commande::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('La commande n\'existe pas.');
        }

        Stripe::setApiKey('sk_test_51PGUNhKxIn14U1N7FeocV88WOem1604Ri0BwHRcA0XEQeUF22wH2mJrMIJGA8WVFkTbGQ7deoQDTqwost5Ds46oH00djCsCWQb');

        $lineItems = [];
        foreach ($order->getLignecommande() as $lignecommande) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $lignecommande->getLivre()->getTitre(),
                    ],
                    'unit_amount' => $lignecommande->getLivre()->getPrix() * 100,
                ],
                'quantity' => $lignecommande->getQuantite(),
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', []);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}









