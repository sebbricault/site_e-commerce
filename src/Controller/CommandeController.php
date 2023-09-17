<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use App\Entity\CommandeDetail;
use App\Form\CommandeType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/commande', name: 'app_commande')]
    public function index(Request $request, Panier $panier): Response
    {
        if (!$this->getUser()->getAdresses()->getValues()) {
            return $this->redirectToRoute('app_add_address');
        }
        $form =$this->createForm(CommandeType::class, null, [
            'user' => $this->getUser(),
        ]);
       
        return $this->render('commande/index.html.twig', [
        'form'=>$form->createView(),
        'panier'=> $panier->getFull(),
    ]);
    }
    #[Route('/commande/recapitulatif', name: 'app_commande_recap')]
    public function add(Request $request, Panier $panier): Response
    {
        $form =$this->createForm(CommandeType::class, null, [
            'user' => $this->getUser(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Modelivraison= $form->get('Livraison')->getData();
            $Livraison=$form->get('adresses')->getData();
            $Contenu_livraison=$Livraison->getFirstname()." ".$Livraison->getLastname();
            $Contenu_livraison.='<br/>'.$Livraison->getPhone();
            $Contenu_livraison.='<br/>'.$Livraison->getAdresse();
            $Contenu_livraison.='<br/>'.$Livraison->getPostal().''.$Livraison->getVille();
            $Contenu_livraison.='<br/>'.$Livraison->getPays();
            $date= new \DateTime();
            $commande= new Commande();
            $commande->setUser($this->getUser());
            $commande->setDate($date);
            $commande->setLivreurName($Modelivraison->getNom());
            $commande->setLivreurPrix($Modelivraison->getPrix());
            $commande->setLivraison($Contenu_livraison);
            $commande->setIspaid(0);
            $this->entityManager->persist($commande);
         

            foreach ($panier->getFull() as $product) {
                $commandeDetail = new CommandeDetail();
                $commandeDetail->setCommande($commande);
                $commandeDetail->setProduct($product['product']->getName());
                $commandeDetail->setQuantity($product['quantity']);
                $commandeDetail->setPrix($product['product']->getPrix());
                $commandeDetail->setTotal($product['product']->getPrix() * $product['quantity']);
                $this->entityManager->persist($commandeDetail);
            }
          
            $this->entityManager->flush();
            
            return $this->render('commande/add.html.twig', [
            'panier'=> $panier->getFull(),
            'modelivraison'=>$Modelivraison,
           'Contenu_livraison'=> $Contenu_livraison,
        ]);
        }
        return $this->redirectToRoute('app_panier');
    }
}
