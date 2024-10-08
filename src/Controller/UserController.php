<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
            $users=$userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/admin/user/show/{id}', name: 'admin_user_show')]
    
    public function show(UserRepository $userRepository,$id): Response
    {
        $user=$userRepository->find($id);
       
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
    public function delete(User $user , EntityManagerInterface $em): Response
    {
        
        $em->remove($user);
        $em->flush();
        
      return    $this->redirectToRoute('app_user');  
        
    }
    
}
