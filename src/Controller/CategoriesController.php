<?php

namespace App\Controller;

use App\Entity\categories;
use App\Form\CategorieType;
use App\Repository\categoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    #[Route('/admin/categories', name: 'admin_categories')]
    public function index(CategoriesRepository $rep): Response
    {
        $categorie = $rep->findAll();
        return $this->render('categories/index.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/admin/categories/create', name: 'admin_categories_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        // Affichage du formulaire
        $categorie = new Categories(); 
        $form = $this->createForm(CategorieType::class, $categorie);

        // Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('categories/create.html.twig', [
            'f' => $form->createView(),
        ]);
    }

    #[Route('/admin/categories/update/{id}', name: 'admin_categories_update')]
    public function update(categories $categorie ,EntityManagerInterface $em,Request $request): Response
    {
        // Affichage du formulaire

        $form = $this->createForm(CategorieType::class, $categorie);

        // Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('categories/update.html.twig', [
            'f' => $form->createView(),
        ]);
    }

    #[Route('/admin/categories/delete/{id}', name: 'admin_categories_delete')]
    public function delete(categories $cat , EntityManagerInterface $em): Response
    {
        
        $em->remove($cat);
        $em->flush();
        
      return    $this->redirectToRoute('admin_categories');  
        
    }
}
