<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AccountPasswordController extends AbstractController
{

    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager; 
    }

    #[Route('/compte/modification-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $notification = null;

        $user = $this->getUser(); 
        $form = $this->createForm(ChangePasswordType::class, $user); 

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData(); 
            if($passwordHasher->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData(); 
                $hashedPassword = $passwordHasher->hashPassword($user, $new_pwd); 

                $user->setPassword($hashedPassword); 
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }


        return $this->render('account/password.html.twig',[
            'form'=>$form->createView(),
            'notification' => $notification
        ]);
    }
}
