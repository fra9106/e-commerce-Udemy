<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {   
    
        $this->cartService = $cartService;
    }
    /**
     * Affiche le panier complet
     * 
     * @Route("/cart", name="app_cart")
     */
    public function index(): Response
    {
        $cart = $this->cartService->getFullCart();
        //dd($cart);
        if(!isset($cart['products'])) {
            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('cart/cart.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * ajoute un produit dans le panier
     * 
     * @Route("/cart/addProductInCart/{id}", name="app_addProductInCart")
     *
     * @return Response
     */
    public function addProductInCart($id): Response
    {
        $this->cartService->addProductInCart($id);
    
        return $this->redirectToRoute('app_cart');
    }

    /**
     * supprime une quantité d'un produit
     * 
     * @Route("/cart/deleteProductInCart/{id}", name="app_deleteProductInCart")
     *
     * @return Response
     */
    public function deleteProductInCart($id) : Response
    {
        $this->cartService->deleteProductInCart($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * supprime un produit dans le panier
     *
     * @Route("/cart/remove/{id}", name="app_remove_product")
     * 
     * @return Response
     */
    public function remove($id) : Response
    {
        $this->cartService->remove($id);
        return $this->redirectToRoute('app_cart');
    }
}
