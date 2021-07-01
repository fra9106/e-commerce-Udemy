<?php

namespace App\Services\Purchases;

use App\Entity\Cart;
use App\Entity\CartDetail;
use App\Entity\Purchase;
use App\Entity\PurchaseDetail;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseService
{
    protected $manager;
    protected $productRepository;

    public function __construct(EntityManagerInterface $manager, ProductRepository $productRepository)
    {
        $this->manager = $manager;
        $this->productRepository = $productRepository;
    }

    public function createPurchase($cart)
    {
        $purchase = new Purchase();

        $purchase->setReference($cart->getReference())
            ->setFullName($cart->getFullName())
            ->setCarrierName($cart->getCarrierName())
            ->setCarrierPrice($cart->getCarrierPrice())
            ->setDeliveryAddress($cart->getDeliveryAddress())
            ->setMoreInformation($cart->getMoreInformation())
            ->setQuantity($cart->getQuantity())
            ->setSubTotalHt($cart->getSubTotalHt())
            ->setTaxe($cart->getTaxe())
            ->setSubTotalTtc($cart->getSubTotalTtc())
            ->setUser($cart->getUser())
            ->setCreatedAt($cart->getCreatedAt());

        $this->manager->persist($purchase);

        $products = $cart->getCartDetails()->getValues();

        foreach ($products as $cartProduct) {
            $purchaseDetail = new PurchaseDetail;

            $purchaseDetail->setPurchase($purchase)
                ->setProductName($cartProduct->getProductName())
                ->setProductPrice($cartProduct->getProductPrice())
                ->setQuantity($cartProduct->getQuantity())
                ->setSubTotalHt($cartProduct->getSubTotalHt())
                ->setSubTotalTtc($cartProduct->getSubTotalTtc())
                ->setTaxe($cartProduct->getTaxe());

            $this->manager->persist($purchaseDetail);
        }

        $this->manager->flush();

        return $purchase;
    }

    public function getLineItems($cart)
    {
        $cartDetail = $cart->getCartDetails();

        $line_items = [];

        foreach ($cartDetail as $details) {

            $product = $this->productRepository->findOneByName($details->getProductName());

            $line_items[] = [

                'price_data' => [

                    'currency' => 'eur',

                    'unit_amount' => $product->getPrice(),

                    'product_data' => [

                        'name' => $product->getName(),

                        'images' => [$_ENV['YOUR_DOMAIN'] . '/uploads/products/' .$product->getImage()],

                    ],

                ],

                'quantity' => $details->getQuantity(),
            ];
        }

        //carrier :
        $line_items[] = [

            'price_data' => [

                'currency' => 'eur',

                'unit_amount' => $cart->getCarrierPrice(),

                'product_data' => [

                    'name' => 'Carrier ( '.$cart->getCarrierName(). ')',

                    'images' => [$_ENV['YOUR_DOMAIN'] . '/uploads/products/'],

                ],

            ],

            'quantity' => 1,
        ];

        //taxe :
        $line_items[] = [

            'price_data' => [

                'currency' => 'eur',

                'unit_amount' => $cart->getTaxe()*100,

                'product_data' => [

                    'name' => 'TVA 20%',

                    'images' => [$_ENV['YOUR_DOMAIN'] . '/uploads/products/'],

                ],

            ],

            'quantity' => 1,
        ];

        return $line_items;

    }



    public function saveCart($data, $user)
    {
        $cart = new Cart();
        $reference = $this->generateUuid();
        $address = $data['checkout']['address'];
        $carrier = $data['checkout']['carrier'];
        $informations = $data['checkout']['informations'];
        $quantity = $data['data']['quantity_cart'];
        $subTotalHt = $data['data']['subTotalHT'];
        $taxe = $data['data']['Taxe'];
        $subTotalTtc = round(($data['data']['subTotalTTC'] + $carrier->getPrice() / 100), 2);


        $cart->setReference($reference)
            ->setFullName($address->getFullName())
            ->setCarrierName($carrier->getName())
            ->setCarrierPrice($carrier->getPrice())
            ->setDeliveryAddress($address)
            ->setMoreInformation($informations)
            ->setCreatedAt(new \DateTime())
            ->setQuantity($quantity)
            ->setSubTotalHt($subTotalHt)
            ->setTaxe($taxe)
            ->setSubTotalTtc($subTotalTtc)
            ->setUser($user);

        $this->manager->persist($cart);

        $cart_detail_array = [];

        foreach ($data['products'] as $products) {
            $cartDetail = new CartDetail();

            $subTotal = $products['quantity'] * $products['product']->getPrice() / 100;

            $cartDetail->setCart($cart)
                ->setProductName($products['product']->getName())
                ->setProductPrice($products['product']->getPrice() / 100)
                ->setQuantity($products['quantity'])
                ->setSubTotalHT($subTotal)
                ->setSubTotalTTC($subTotal * 1.2)
                ->setTaxe($subTotal * 0.2);
            $this->manager->persist($cartDetail);
            $cart_detail_array[] = $cartDetail;
        }

        $this->manager->flush();

        return $reference;
    }

    public function generateUuid() // génère un identifiant unique pour sauvegarger un panier en bdd
    {
        // Initialise le générateur de nombre aléatoire Mersenne Twister
        mt_srand((float)microtime() * 100000);

        //strtoupper : renvoi une chaine de caractère en maj
        //uniqid : génère un id unique
        $charid = strtoupper(md5(uniqid(rand(), true)));

        //génère une chaine d'1 octet à partir d'un nombre
        $hyphen = chr(45);

        //substr : retourne un segment de chaîne
        $uuid = ""

            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        return $uuid;
    }
}
