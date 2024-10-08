<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Lignecommandes;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface; // Importer l'interface EntityManagerInterface
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

//#[Route('/commandes', name: 'app_commande')]
class CommandeController extends AbstractController
{
   
   
    #[Route('/ajout', name: 'app_commande_add')]
    public function ajout(SessionInterface $session, LivresRepository $livresRepository, EntityManagerInterface $em): Response
    {
        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('app_home');
        }

        $order = new Commande();
        $order->setIdUser($this->getUser());
        $order->setDtCommande(new \DateTime());

        foreach ($panier as $pan => $quantite) {
            $orderDetails = new Lignecommandes();
            $livre = $livresRepository->find($pan);
            $orderDetails->setLivre($livre);
            $orderDetails->setQuantite($quantite);
            $order->addLignecommande($orderDetails);
        }

        $em->persist($order);
        $em->flush();

        $session->remove('panier');

        $this->addFlash('success', 'Commande créée avec succès <3');
        return $this->redirectToRoute('app_commande_confirm', ['id' => $order->getId()]);
    }

    #[Route('/commande/confirm/{id}', name: 'app_commande_confirm')]
    public function confirm(int $id, EntityManagerInterface $em): Response
    {
        $order = $em->getRepository(Commande::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('La commande n\'existe pas.');
        }

        return $this->render('commande/confirm.html.twig', [
            'order' => $order,
        ]);
    }
}