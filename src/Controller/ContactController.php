<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $prenom = $data['prenom'];
            $nom= $data['nom'];
            $message=$data['contenue'];
        

            $email = (new Email())
                ->from('hello@example.com')
                ->to('olivier.formateur@cefii.fr')
                ->addTo('sebastiendu28@hotmail.fr')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Nous contacter')
                ->text('test 2')
                ->html('<p>' . $nom . ' ' . $prenom . ' ' . $message . '  </p>');

            $mailer->send($email);
            return $this->redirectToRoute('app_home');
        }
        return $this->render(
            'contact/index.html.twig',
            ['form' => $form->createView(),]
        );
    }
}
