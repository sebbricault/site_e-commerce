<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/adresses', name: 'app_account_adress')]
    public function index(): Response
    {
        return $this->render('account/adress.html.twig');
    }
      /**
     * Ajout adresse
     */
    #[Route('/compte/ajouter-une-adresse', name: 'app_add_address')]
    public function add(Request $request, Panier $panier): Response
    {
        $adresse = new Adresse();
       
        $form=$this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();
            // if ($panier->get()) {
            //     return $this->redirectToRoute('app_commande');
            // } else {
            return $this->redirectToRoute('app_account_adress');
            // }
        }
       
        return $this->render('account/adresseForm.html.twig', [
             'form' => $form->createView(),
        ]);
    }
     #[Route('/compte/modifier-une-adresse/{id}', name: 'app_edit_address')]
    public function edit(Request $request, $id): Response
    {
        $address= $this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if (!$address || $address->getUser() != $this->getUser()) {
        }
        $form=$this->createForm(AdresseType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_adress');
        }
       
        return $this->render('account/adresseForm.html.twig', [
             'form' => $form->createView(),
        ]);
    }
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_delete_address')]
    public function delete($id): Response
    {
        $address= $this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_account_adress');
    }
}
