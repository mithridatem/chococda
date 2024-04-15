<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'Saisir votre email',
                'required'=> true,
                'empty_data' => ''
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Saisir votre mot de passe',
                'hash_property_path' => 'password',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Saisir votre nom',
                'required'=> true,
                'empty_data' => ''
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Saisir votre prénom',
                'required'=> true,
                'empty_data' => ''
            ])
            ->add('image', FileType::class, [
                'label' => 'Choisir une image',
                'required'=> false,
                'empty_data' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
