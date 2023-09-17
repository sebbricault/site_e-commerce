<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Livraison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * pour recupérer seulement l'adresse du client
         */
        $user=$options['user'];
   
        $builder
            ->add('adresses', EntityType::class, [
                'label'=>'choisissez votre adresse de livraison',
                'required'=> true,
                'class'=> Adresse::class,
                'choices'=>$user->getAdresses(),
                'multiple'=> false,
                'expanded'=>true,
            ])
            ->add('Livraison', EntityType::class, [
                'label'=>'choisissez votre mode de livraison',
                'required'=> true,
                'class'=> Livraison::class,
                'multiple'=> false,
                'expanded'=>true,
            ])
            ->add('Submit', SubmitType::class, [
                'label'=>'Valider ma commande',
                'attr'=>['class'=>'btn btn-block btn-dark mb-5 mt-5']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => array()
        ]);
    }
}
