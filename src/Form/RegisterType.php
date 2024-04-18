<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Saisir votre email',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Saisir votre mot de passe',
                'required' => true,
                'empty_data' => '',
                'toggle'=> true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Saisir votre nom',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Saisir votre prénom',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('image', FileType::class, [
                'label' => 'Choisir une image',
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/bmp',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Merci d\'utiliser une image au format jpg, png ou bmp',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
