<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\EmailService;
use App\Service\FileUploadService;
use App\Service\UserService;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hash,
        private readonly EmailService $emailService,
        private readonly FileUploadService $fileUploadService,
        private readonly UserService $userService
    ) {
    }
    #[Route('/register', name: 'app_register_create')]
    public function create(
        Request $request
    ): Response {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $user->setStatus(false);
            $user->setPassword($this->hash->hashPassword($user, $user->getPassword()));
            //récupération de l'image
            $imageFile = $form->get('image')->getData();
            //test si l'image existe
            if ($imageFile) {
                //récupération du nom et déplacement de l'image
                $imageFileName = $this->fileUploadService->upload($imageFile);
                //set du nom de l'image
                $user->setImage($imageFileName);
            }
            try {
                //ajout du compte utilisateur
                $this->userService->create($user);
                //construction du corp du mail  
                $body = $this->render('email/activation.html.twig', ["id" => $user->getId()]);
                //envoi du mail
                $this->emailService->sendEmail($user->getEmail(), "Activation du compte", $body->getContent());
                $type = 'success';
                $msg = 'Le compte a ete ajoute';
      
            } catch (\Throwable $th) {
                $msg = $th->getMessage();
                $type = "danger";
            }
            //affichage du message
            $this->addFlash($type,$msg);
        }
        return $this->render('register/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
    
    #[Route('/register/activate/{id}', name:'app_register_activate')]
    public function activeAccount($id) {
        //récupération du compte
        $user = $this->userService->findOneBy($id);
        //test si le compte existe
        if($user) {
            //modifier le status
            $user->setStatus(true);
            $this->userService->update($user);
            //redirige vers la connexion
            return $this->redirectToRoute('app_login');
        }
        //si il n'existe pas on regirige vers la création de compte
        return $this->redirectToRoute('app_register_create');
    }

    #[Route('/register/test/{email}', name:'app_register_test')]
    public function testEmail($email, UserRepository $userRepository) {
        dd($userRepository->findAllUserNotMe($email));
    }

    //exemple récupérer l'utilisateur courant
    #[Route('/register/test', name:'app_register_test')]
    public function testUser():Response {
        dd($this->getUser());
    }
}
