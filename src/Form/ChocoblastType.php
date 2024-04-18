<?php

namespace App\Form;

use App\Entity\Chocoblast;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChocoblastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Saisir le titre',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('createAt', DateType::class, [
                'label' => 'Choisir une date',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true
            ])
            ->add('target', EntityType::class, [
                'class' => User::class,
                'autocomplete' => true,
                'label' => 'Sélectionner la cible',
            ])
            ->add('ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chocoblast::class,
        ]);
    }
}
