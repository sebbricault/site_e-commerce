<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManger = $entityManager;
    }

    #[Route('/mon-panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'panier'=> $panier->getFull(),
        ]);
    }
    /**
     * Ajout au panier
     */
    #[Route('/panier/add/{id}', name: 'app_add_panier')]
    public function add($id, Panier $panier): Response
    {
        $panier->add($id);
        return $this->redirectToRoute('app_panier');
    }
    /**
     * vider panier
     *
     * @param panier $panier
     * @return Response
     */
    #[Route('/panier/remove', name: 'app_remove_panier')]
    public function remove(panier $panier): Response
    {
        $panier->remove();
        return $this->redirectToRoute('app_product');
    }
    /**
     * supprimer article
     */
        #[Route('/panier/delete/{id}', name: 'app_delete_panier')]
    public function delete($id, Panier $panier): Response
    {
        $panier->delete($id);
        return $this->redirectToRoute('app_panier');
    }
    
    #[Route('/panier/decrement/{id}', name: 'decrement_panier')]
    public function decrement(Panier $panier, $id)
    {
        $panier->decrement($id);

        return $this->redirectToRoute('app_panier');
    }
}
