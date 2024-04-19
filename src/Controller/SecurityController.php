<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($this->getUser()) {
            $msg = "connecte";
            $type = "success";
            $this->addFlash($type, $msg);
        }
        if ($error) {
            $type = "warning";
            switch ($error->getMessage()) {
                case 'The presented password is invalid.':
                    $msg = "Le mot de passe est invalide";
                    break;
                case 'Bad credentials.':
                    $msg = "Le mail est invalide";
                    break;
            }
            $this->addFlash($type, $msg);
        }
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
