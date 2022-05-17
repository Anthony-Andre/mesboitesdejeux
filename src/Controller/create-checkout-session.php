<?php

use App\Classe\Cart;
use Stripe\Checkout\Session;
use Stripe\Stripe;

require 'vendor/autoload.php';
// This is your test secret API key.
Stripe::setApiKey('sk_test_51KYAzOLdX1uHjse7UHfWYLuzAP821Nvblnr9gqSxK9FlDcbpcjQZBVYXeSP4OwFzp1A6eihOkCGGsMs21HJyno3000L9HwmzGK');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242/public';

$products_for_stripe = []; 

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

$checkout_session = Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => 'price_1KYBquLdX1uHjse7B8dlDyA0',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);