<?php

namespace App\Controller\CGU;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGUController extends AbstractController
{
    /**
     * @Route("/conditions-generales", name="app_conditions_generales")
     */
    public function conditionsGenerales(): Response
    {
        return $this->render('cgu/conditions_generales.html.twig');
    }
}
