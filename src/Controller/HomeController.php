<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homePage(ProductRepository $repoProducts): Response
    {

        $products = $repoProducts->findAll();

        $productsBestSeller = $repoProducts->findByIsBest(1);
        $productsSpecialOffer = $repoProducts->findByIsSpecialOffer(1);
        $productsNewArrival = $repoProducts->findByIsNewArrival(1);
        $productsFeatured = $repoProducts->findByIsFeatured(1);

        return $this->render('home/home_page.html.twig', [
            'products' => $products,
            'productsBestSeller' => $productsBestSeller,
            'productsNewArrival' => $productsNewArrival,
            'productsSpecialOffer' => $productsSpecialOffer,
            'productsFeatured' => $productsFeatured

        ]);
    }

    /**
     * @Route("/product/{slug}", name="app_product_show")
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product) : Response
    {
        if (!$product){
            throw $this->createNotFoundException("Ce produit n'existe pas ! 🤔");
        }
        return $this->render('home/product_show.html.twig', [
            'product' => $product
        ]);

    }
}
