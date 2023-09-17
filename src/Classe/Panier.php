<?php
namespace App\Classe;

// Remplace la sessionInterface avec symfony 6
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * gestion de mon panier
 */

class Panier
{
    private $stack;
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, RequestStack $stack)
    {
        $this->session= $stack->getSession();
        $this->entityManager= $entityManager;
    }
    public function add($id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        return $this->session->set('panier', $panier);
    }
    public function get()
    {
        return $this->session->get('panier');
    }
      public function remove()
      {
          return $this->session->remove('panier');
      }
     public function delete($id)
     {
         $panier= $this->session->remove('panier', []);
         unset($panier[$id]);
         return $this->session->set('panier', $panier);
     }
    public function getFull()
    {
        $panierComplete=[];
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                // protection pour supprimer l'id ajouter a la main dans l'url
                $product_objet=$this->entityManager
                   ->getRepository(Product::class)
                   ->findOneById($id);
                if (!$product_objet) {
                    $this->delete($id);
                    continue;
                }
                $panierComplete[]=[
                   'product'=> $product_objet,
                   'quantity'=>$quantity
                ];
            }
        }
        return $panierComplete;
    }
    public function decrement($id)
    {
        $panier = $this->session->get('panier', []);

        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }

        return $this->session->set('panier', $panier);
    }
}
