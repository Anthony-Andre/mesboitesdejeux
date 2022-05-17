<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if (!$order->getIsPaid()) {
            // Vider la session "cart"
            $cart->remove();

            // Modifier le statut de paiement à 1 : 
            $order->setIsPaid(1);
            $this->entityManager->flush();
        }

        // Envoyer un email à notre client pour lui confirmer sa commande 

        $mail = new Mail();
        $content = "Bonjour " . $order->getUser()->getFirstName() . ",<br><br>Nous vous remercions pour votre commande. Vous êtes une bonne personne héhé";
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), "Votre commande sur MyGameBox est bien validée", $content);


        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
