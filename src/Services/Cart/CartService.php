<?php

namespace App\Services\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService 
{
    protected $session;
    protected $productRepository;
    protected $tva = 0.2;
    

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
     * supprime un produit dans le panier
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

        $quantity_cart = 0;

        $subTotal = 0;

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if ($product) {
                $fullCart['products'][]=
                [
                    "quantity" => $quantity,
                    "product" => $product
                ];

                $quantity_cart += $quantity;
                $subTotal += $quantity * $product->getPrice()/100;

            }else{
                $this->deleteProductInCart($id);
            }
            
        }

        $fullCart['data'] = [
            "quantity_cart" => $quantity_cart,
            "subTotalHT" => $subTotal,
            "Taxe" => round($subTotal * $this->tva,2),
            "subTotalTTC" => round(($subTotal + ($subTotal * $this->tva)), 2)
        ];

        return $fullCart;
        
    }

}