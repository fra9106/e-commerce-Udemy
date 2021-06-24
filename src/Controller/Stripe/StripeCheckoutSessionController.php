<?php

namespace App\Controller\Stripe;

use App\Services\Cart\CartService;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCheckoutSessionController extends AbstractController
{
    /**
     * @Route("/create-checkout-session", name="app_create_checkout_session")
     */
    public function index(CartService $cartService): Response
    {
        $cart = $cartService->getFullCart();

        Stripe::setApiKey('sk_test_51IlrB5FbsfZOypKxHvt20Mmgc2wf8B5a0XnE5OL68A6rSuwnTQkbNfQP1BcDvAIT7VpZZH6o2QlRqp6wgifCoMB200gsNzGNBv');

        $line_items = [];
          
        foreach ($cart['products'] as $data_product) {

            $product = $data_product['product'];

            $line_items[] = [
              
                  'price_data' => [
            
                  'currency' => 'eur',
            
                  'unit_amount' => $product->getPrice(),
            
                  'product_data' => [
            
                    'name' => $product->getName(),
            
                    'images' => [$_ENV['YOUR_DOMAIN'].'/public/assets/uploads/products/'.$product->getImage()],
            
                  ],
            
                ],
            
                'quantity' => $data_product['quantity'],
            ];
          }

        $checkout_session = Session::create([

            'payment_method_types' => ['card'],
          
            'line_items' => $line_items,
          
            'mode' => 'payment',
          
            'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-success',
          
            'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-cancel',
          
          ]);

          

        return $this->json(['id' => $checkout_session->id]);
    }
}
