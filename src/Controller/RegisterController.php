<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; 
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager; 
    }

    // public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new User(); 
        $form =$this->createForm(RegisterType::class, $user); 

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData(); 

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword()); 
            $user->setPassword($hashedPassword);

            // $doctrine = $this->doctrine->getManager(); 
            $this->entityManager->persist($user); 
            $this->entityManager->flush(); 
        }

        return $this->render('register/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
