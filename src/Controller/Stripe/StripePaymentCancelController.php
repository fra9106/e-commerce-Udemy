<?php

namespace App\Controller\Stripe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripePaymentCancelController extends AbstractController
{
    /**
     * @Route("/stripe-payment-cancel", name="app_stripe_payment_cancel")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Stripe/StripePaymentCancelController.php',
        ]);
    }
}
