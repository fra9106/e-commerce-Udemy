<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AddressController extends AbstractController
{
    /**
     * @Route("/addresses", name="app_addresses", methods={"GET"})
     */
    public function addresses(AddressRepository $addresses): Response
    {
        return $this->render('address/index.html.twig', [
            'addresses' => $addresses->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_address_new", methods={"GET","POST"})
     * 
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, CartService $cartService): Response
    {
        $address = new Address();
        $address->setUser($this->getUser());
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            if ($cartService->getFullCart()) {
                return $this->redirectToRoute('app_checkout');
            }

            $this->addFlash('success', 'Votre adresse a bien été créé 🤗 !');

            return $this->redirectToRoute('app_addresses');
        }

        return $this->render('address/new.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_address_edit", methods={"GET","POST"})
     * 
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre adresse a bien été modifié 🤗 !');

            return $this->redirectToRoute('app_addresses');
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_address_delete", methods={"POST"})
     * 
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();

            $this->addFlash('success', 'Votre adresse a bien été supprimée 🤗 !');
        }

        return $this->redirectToRoute('app_addresses');
    }
}
