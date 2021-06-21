<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{
    /**
     * @Route("/checkout", name="app_checkout")
     */
    public function checkout(CartService $cartService, Request $request): Response
    {
        $user = $this->getUser();

        $cart = $cartService->getFullCart();

        if (!$cart) {
            return $this->redirectToRoute('app_hompage');
        }

        if (!$user->getAddresses()->getValues()) {

            $this->addFlash('success_message_checkout', "Merci d'entrer une adresse pour pouvoir continuer 🙂");
            return $this->redirectToRoute('app_address_new');
        
        }

        $form = $this->createForm(CheckoutType::class, null, ['user' =>$user]);

        $form->handleRequest($request);

        //if ( $form->isSubmitted() && $form->isValid()) {

        //}

        return $this->render('check_out/check_out.html.twig', [
            'cart' => $cart,
            'checkout' => $form->createView()
    
        ]);
    }
}
