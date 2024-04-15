<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_create')]
    public function create(): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        return $this->render('register/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}
