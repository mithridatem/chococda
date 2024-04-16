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

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hash,
        private readonly EmailService $emailService,
        private readonly UserRepository $userRepository,
        private readonly FileUploadService $fileUploadService
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
            //Test si le compte n'existe pas
            if (!$this->userRepository->findOneBy(["email" => $user->getEmail()])) {
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
                $this->em->persist($user);
                $this->em->flush();
                $body = $this->render('email/activation.html.twig', ["id" => $user->getId()]);
                $this->emailService->sendEmail($user->getEmail(), "Activation du compte", $body->getContent());
                $type = 'success';
                $msg = 'Le compte ' . $user->getEmail() . ' a été ajouté en BDD';
            }
            //si le compte existe
            else{
                $type = 'danger';
                $msg = 'Le compte ' . $user->getEmail() . ' existe déja';
            }
            $this->addFlash($type,$msg);
        }
        return $this->render('register/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}
