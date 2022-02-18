<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; 
use app\form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class RegisterController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/inscription', name: 'register')]
    public function index(Request $request): Response
    {

        $user = new User(); 
        $form =$this->createForm(RegisterType::class, $user); 

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData(); 

            $doctrine = $this->doctrine->getManager(); 
            $doctrine->persist($user); 
            $doctrine->flush(); 

        }

        return $this->render('register/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
