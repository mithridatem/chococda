<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_create')]
    public function create(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hash
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setRoles(["ROLE_USER"]);
            $user->setStatus(false);
            $user->setPassword($hash->hashPassword($user,$user->getPassword()));
            $em->persist($user);
            $em->flush();
        }
        return $this->render('register/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}
