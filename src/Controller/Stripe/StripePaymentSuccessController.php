<?php

namespace App\Controller\Stripe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripePaymentSuccessController extends AbstractController
{
    /**
     * @Route("/stripe-payment-success", name="app_stripe_payment_success")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Stripe/StripePaymentSuccessController.php',
        ]);
    }
}
