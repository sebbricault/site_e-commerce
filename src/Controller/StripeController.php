<?php

namespace App\Controller;

use App\Classe\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Stripe;
use Stripe\Checkout\Session;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session', name: 'stripe_create_session')]
    public function index(Panier $panier, EntityManagerInterface $entityManager): Response
    {
        return $this->render('commande/add.html.twig', [
            'stripe_key' => 'pk_test_51MHUYSDrqZtdbjt7BbxC5kXHp5FaMcdgCMBc25FYqNDYJ8OwltsGQsHmks2bKy9eHJIpQhLtkJQ6NXRDhc2YrwnJ008bUhcUmh',
        ]);
    }
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, Panier $panier)
    {
        $product_for_stripe=[];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000/';
        foreach ($panier->getFull() as $product) {
            $product_for_stripe[]=[
                'price_data' => [
                'currency'=>'eur',
                'unit_amont'=>$product['product']->getPrix(),
                'product_data'=>['name'=>$product['product']->getName(),
                'images'=>[$YOUR_DOMAIN."/uploads/".$product['product']->getPhoto()]]
                ],
                'quantity' => $product['quantity'],
            ];
            Stripe\Stripe::setApiKey('sk_test_51MHUYSDrqZtdbjt7MgrlyYfPLpAMmcLJN6kUw1Ub87PUi9lPt7C9zVBoHLmMKei7Qjo8U4OfZ7YKeF82m4eMvwsm00LK4JvhUC');
            // Stripe\Charge::create([
              
            //     $product_for_stripe,
  
            // ]);
           
            $panier->remove();
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    }
}
