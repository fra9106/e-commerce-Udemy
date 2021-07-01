<?php

namespace App\Controller\Stripe;

use App\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripePaymentCancelController extends AbstractController
{
    /**
     * @Route("/stripe-payment-cancel/{stripeCheckoutSessionId}", name="app_stripe_payment_cancel")
     */
    public function index(?Purchase $purchase): Response
    {
        if(!$purchase || $purchase->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('stripe/stripe_cancel_payment.html.twig', [
            'purchase' => $purchase
        ]);
    }
}
