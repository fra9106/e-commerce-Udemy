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
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/checkout", name="app_checkout")
     */
    public function checkout(Request $request): Response
    {
        $user = $this->getUser();

        $cart = $this->cartService->getFullCart();
        //dd($cart);
        if (!isset($cart['products'])) {
            return $this->redirectToRoute('app_homepage');
        }

        if (!$user->getAddresses()->getValues()) {

            $this->addFlash('success_message_checkout', "Merci d'entrer une adresse pour pouvoir continuer 🙂");
            return $this->redirectToRoute('app_address_new');
        
        }

        $form = $this->createForm(CheckoutType::class, null, ['user' =>$user]);

        $form->handleRequest($request);

        return $this->render('check_out/check_out.html.twig', [
            'cart' => $cart,
            'checkout' => $form->createView()
    
        ]);
    }

    /**
     * @Route("/checkout/confirm", name="app_checkout_confirm")
     *
     * @return Response
     */
    public function confirm(Request $request) : Response 
    {
        $user = $this->getUser();
        $cart = $this->cartService->getFullCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute('app_homepage');
        }

        if (!$user->getAddresses()->getValues()) {

            $this->addFlash('success_message_checkout', "Merci d'entrer une adresse pour pouvoir continuer 🙂");
            return $this->redirectToRoute('app_address_new');
        
        }

        $form = $this->createForm(CheckoutType::class, null, ['user' =>$user]);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $address = $data['address'];
            $carrier = $data['carrier'];
            $informations = $data['informations'];

            //dd($data);

            return $this->render('check_out/confirm.html.twig', [
                'cart' => $cart,
                'checkout' => $form->createView(),
                'address' => $address,
                'carrier' => $carrier,
                'informations' => $informations
            ]);

        }

        return $this->redirectToRoute('app_checkout');

    }
}
