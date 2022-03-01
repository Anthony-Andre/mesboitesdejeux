<?php

namespace App\Controller;

use App\Classe\Cart;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session', name: 'stripe_create_session')]
    public function index(Cart $cart): Response
    {

        $products_for_stripe = []; 

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        foreach ($cart->getFull() as $product) {
        
            $products_for_stripe[] = [
                'price_data' =>[
                    'currency' => 'eur', 
                    'unit_amount' => $product['product']->getPrice(), 
                    'product_data' => [
                        'name' => $product['product']->getName(), 
                        'images' => [$YOUR_DOMAIN."/uploads/".$product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];

        }

       Stripe::setApiKey('sk_test_51KYAzOLdX1uHjse7UHfWYLuzAP821Nvblnr9gqSxK9FlDcbpcjQZBVYXeSP4OwFzp1A6eihOkCGGsMs21HJyno3000L9HwmzGK');

            

            $checkout_session = Session::create([
                'line_items' => [[
                    $products_for_stripe
                ]],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/success.html',
                'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

            $response = new JsonResponse(['id' => $checkout_session->id]);
            return $response;
    }
}
