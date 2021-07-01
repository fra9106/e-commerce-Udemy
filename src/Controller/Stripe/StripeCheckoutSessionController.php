<?php

namespace App\Controller\Stripe;

use Stripe\Stripe;
use App\Entity\Cart;
use Stripe\Checkout\Session;
use App\Services\Purchases\PurchaseService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCheckoutSessionController extends AbstractController
{
  /**
   * @Route("/create-checkout-session/{reference}", name="app_create_checkout_session")
   */
  public function index(?Cart $cart, PurchaseService $purchaseService, EntityManagerInterface $manager): Response
  {

    $user = $this->getUser();

    if (!$cart) {
      return $this->redirectToRoute('app_homepage');
    }

    $purchase = $purchaseService->createPurchase($cart);

    Stripe::setApiKey('sk_test_51IlrB5FbsfZOypKxHvt20Mmgc2wf8B5a0XnE5OL68A6rSuwnTQkbNfQP1BcDvAIT7VpZZH6o2QlRqp6wgifCoMB200gsNzGNBv');


    $checkout_session = Session::create([

      'customer_email' => $user->getEmail(),

      'payment_method_types' => ['card'],

      'line_items' => $purchaseService->getLineItems($cart),

      'mode' => 'payment',

      'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-success/{CHECKOUT_SESSION_ID}',

      'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-cancel/{CHECKOUT_SESSION_ID}',

    ]);

    $purchase->setStripeCheckoutSessionId($checkout_session->id);

    $manager->flush();


    return $this->json(['id' => $checkout_session->id]);
  }
}
