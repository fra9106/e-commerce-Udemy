<?php

namespace App\Controller\Stripe;

use App\Entity\Purchase;
use App\Services\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripePaymentSuccessController extends AbstractController
{
    /**
     * @Route("/stripe-payment-success/{stripeCheckoutSessionId}", name="app_stripe_payment_success")
     */
    public function index(?Purchase $purchase, CartService $cartService, EntityManagerInterface $manager): Response
    {
        if(!$purchase || $purchase->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_homepage');
        }

        if(!$purchase->getIsPaid()) {
            $purchase->setIsPaid(true);
            $manager->flush();
            $cartService->empty();
        }


        return $this->render('stripe/stripe_success_payment.html.twig', [
            'purchase' => $purchase
        ]);
    }
}
