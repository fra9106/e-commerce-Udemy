<?php

namespace App\Services\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService 
{
    protected $session;
    protected $productRepository;
    

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        
    }

    /**
     * retourne le panier (tableau par la session)
     *
     * @return array
     */
    protected function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    /**
     * sauvegarde le panier avec son contenu (update)
     *
     * @return void
     */
    protected function saveCart($cart)
    {
        $this->session->set('cart', $cart);
        $this->session->set('cartData', $this->getFullCart());
    }
    
    /**
     * vider le panier
     *
     * @return void
     */
    public function empty()
    {
        $this->saveCart([]);
    }

    /**
     * remove
     *
     * @return void
     */
    public function remove(int $id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);

        $this->saveCart($cart);
    }

    /**
     * ajout d'un produit dans le panier
     *
     * @return void
     */
    public function addProductInCart($id)
    {
        $cart = $this->getCart();

        if(isset($cart[$id])) {
            
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        

        $this->saveCart($cart);
    }

    /**
     * supprime un un produit dans le panier
     *
     * @return void
     */
    public function deleteProductInCart(int $id) {

        $cart = $this->getCart();

        if(!isset($cart[$id])) { // si le produit extiste bien dans le panier
            return;
        }

        if($cart[$id] === 1) { //// si le panier à  moins 1 produit de cet id... 

            $this->remove($id);
            return;
        } 

        $cart[$id]--;

        $this->saveCart($cart); // et tu set!
    }

    /**
     * retourne le panier complet
     *
     * @return array
     */
    public function getFullCart(): array
    {
        $cart = $this->getCart();

        $fullCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if ($product) {
                $fullCart[]=
                [
                    "quantity" => $quantity,
                    "product" => $product
                ];

            }else{
                $this->deleteProductInCart($id);
            }
            
        }
        return $fullCart;
        
    }

}