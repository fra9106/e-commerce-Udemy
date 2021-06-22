<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{
    protected $cartService;
    protected $session;

    public function __construct(CartService $cartService, SessionInterface $session)
    {
        $this->cartService = $cartService;
        $this->session = $session;
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

        if ($this->session->get('checkout_data')) { // vérifie s'il y a tjrs une session
             return $this->redirectToRoute('app_checkout_confirm'); // renvoi sur la page de confirmation
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

        if ( $form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')) {

            if ($this->session->get('checkout_data')) {
                $data = $this->session->get('checkout_data');
            }else{
                $data = $form->getData();
                $this->session->set('checkout_data', $data);
            }
            

            $address = $data['address'];
            $carrier = $data['carrier'];
            $informations = $data['informations'];

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

    /**
     * @Route("/checkout/edit", name="app_checkout_edit")
     *
     * @return Response
     */
    public function checkoutEdit(): Response
    {
        $this->session->set('checkout_data',[]);
        return $this->redirectToRoute("app_checkout");
    }
}
