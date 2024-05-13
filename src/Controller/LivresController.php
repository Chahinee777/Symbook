<?php

namespace App\Controller;

use App\Entity\categories;
use App\Entity\Livres;
use App\Form\LivreType;
use App\Repository\categoriesRepository;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;


//#[IsGranted('ROLE_ADMIN')]
class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'admin_livres')]
    public function index(LivresRepository $livresRepository): Response
    {
        $cat=new categories();
       $livres=$livresRepository->findAll();
     //   $livres=$livresRepository->findGreaterThan(99);
      //  dd($livres);
        return $this->render('livres/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/admin/livres/show/{id}', name: 'admin_livres_show')]
    
    public function show(LivresRepository $livresRepository,$id): Response
    {
        $livre=$livresRepository->find($id);
       
        return $this->render('livres/show.html.twig', [
            'livre' => $livre,
        ]);
    }

 
    // Assurez-vous que la classe Categories est bien importée en haut de votre fichier
    
    #[Route('/admin/livres/create', name: 'admin_livres_create')]
    public function create(Request $request, EntityManagerInterface $em, categoriesRepository $rep): Response
    {
        if ($request->isMethod('POST')) {
            $titre = $request->request->get('titre');
            $editeur = $request->request->get('editeur');
            $prix = $request->request->get('prix');
            $isbn = $request->request->get('isbn');
            $editedAt = new \DateTimeImmutable();
            $slug = $request->request->get('slug');
            $resume = $request->request->get('resume');
            $catId = $request->request->get('categorie');
    
            $categorie = $rep->find($catId);
    
            $livre = new Livres();
            
            $livre->setTitre($titre)
                ->setEditeur($editeur)
                ->setPrix($prix)
                ->setISBN($isbn)
                ->setEditedAt($editedAt)
                ->setSlug($slug)
                ->setResume($resume)
                ->setCategorie($categorie);
    
            $em->persist($livre);
            $em->flush();
    
            return $this->redirectToRoute('admin_livres');
        }
    
        return $this->render('livres/create.html.twig');
    }
    
    
    #[Route('/admin/livres/delete/{id}', name: 'admin_livres_delete')]
    public function delete(Livres $livre , EntityManagerInterface $em): Response
    {
        
        $em->remove($livre);
        $em->flush();
        
      return    $this->redirectToRoute('admin_livres');  
        
    }

    #[Route('/livres/update/{id}', name: 'admin_livres_update')]
    public function update(Livres $liv ,EntityManagerInterface $em,Request $request): Response
    {
    

        $form = $this->createForm(LivreType::class, $liv);

        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($liv);
            $em->flush();
            return $this->redirectToRoute('admin_livres');
        }

        return $this->render('livres/update.html.twig', [
            'f' => $form->createView(),
        ]);
    }
   

    #[Route('/livres/search', name: 'livres_search')]
    public function search(Request $request, LivresRepository $rem): Response
    {
        $searchTerm = $request->query->get('search');
    
        $livres = $rem->rechercher($searchTerm);
    
        return $this->render('livres/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/admin/livres', name: 'admin_livres')]
    public function pagination(LivresRepository $livresRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $query = $livresRepository->createQueryBuilder('l')->getQuery();
        $livres = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('livres/index.html.twig', [
            'livres' => $livres,
        ]);
    }


}


//cash_clear