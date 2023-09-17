<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Commmantaire;
use App\Entity\User;
use App\Entity\Commande;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/produits', name: 'app_product')]
    public function index(): Response
    {
        $products= $this->entityManager->getRepository(Product::class)->findAll();
       
        return $this->render('product/index.html.twig', [
            'products'=>$products,
        ]);
    }
    #[Route('/produit/{slug}{id}', name: 'product')]
    public function show($slug, $id, Request $request): Response
    {
        $product= $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $commentaires= $this->entityManager->getRepository(Commmantaire::class)->findByComm($id);
        $commande=$this->entityManager->getRepository(Commande::class)->findByCommande();
    
        $commentaire = new Commmantaire();
        $form= $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $Message = $form->getData()->getMessage();
            $user=$this->getUser();
            $commentaire->setUser($user);
            $commentaire->setMessage($Message);
            $name= $commentaire->getUser()->getFirstName();
            $commentaire->setName($name);
            $commentaire->setCreatedAt($date);
            $commentaire->setProduit($product);
            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
        }

        if (!$product) {
            return $this->redirectToRoute('app_product');
        }
     
        return $this->render('product/show.html.twig', [
            'product'=>$product,
            'form'=>$form->createView(),
            'commentaire'=>$commentaires,
            'commandes'=>$commande,

        ]);
    }
}
