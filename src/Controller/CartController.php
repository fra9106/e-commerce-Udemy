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
        return $this->render('cart/cart.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * ajoute un produit
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
     * supprime un produit
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
}
