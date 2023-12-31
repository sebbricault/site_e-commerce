<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr'=>['placeholder'=>'Nommez votre adresse']
            ])
            ->add('firstname', TextType::class, [
                'label'=>'Votre prénom ',
                'attr'=>['placeholder'=>'Entrez votre prénom']
            ])
            ->add('lastname', TextType::class, [
                'label'=>'Votre nom',
                'attr'=>['placeholder'=>'Entrez votre nom']
            ])
            ->add('adresse', TextType::class, [
                'label'=>'Votre adresse',
                'attr'=>['placeholder'=>'8 rue des lylas ...']
            ])
            ->add('postal', TextType::class, [
                'label'=>'Votre code postal ?',
                'attr'=>['placeholder'=>'Entrez votre code postal']
            ])
            ->add('ville', TextType::class, [
                'label'=>'ville',
                'attr'=>['placeholder'=>'Entrez votre ville']
            ])
            ->add('pays', CountryType::class, [
                'label'=>'Pays',
               'attr'=>['placeholder'=>'Votre pays']
           ])
            ->add('phone', TelType::class, [
                'label'=>'Votre téléphone',
                'attr'=>['placeholder'=>'Entrez votre télephone']
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Ajouter mon adresse',
                 'attr'=>['class'=>'btn-block btn-dark']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
