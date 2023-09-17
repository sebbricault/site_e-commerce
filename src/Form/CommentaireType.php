<?php

namespace App\Form;

use App\Entity\Commmantaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          
            ->add('message', TextareaType::class, ['label'=>"Votre Avis :"])
            ->add('submit', SubmitType::class, ['label'=>"Envoyer",
            'attr'=>['class'=>'btn-block btn-dark']])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commmantaire::class,
        ]);
    }
}
