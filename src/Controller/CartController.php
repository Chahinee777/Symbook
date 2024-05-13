<?php
namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController {
    
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, LivresRepository $livresRepository)
    {
        $panier = $session->get('panier', []);
        // Initialize variables
        $data = [];
        $total = 0;
        $totalQuantity = 0;

        foreach($panier as $id => $livre){
            $livre = $livresRepository->find($id);
            $quantity = $panier[$id];

            $data[] = [
                'livre' => $livre,
                'quantity' => $quantity
            ];
            $totalQuantity += $quantity;
            $total += $livre->getPrix() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact('data', 'total', 'totalQuantity'));
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Livres $product, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On ajoute le produit dans le panier s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Livres $livre, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $livre->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On retire le produit du panier s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Livres $livre, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $livre->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}
