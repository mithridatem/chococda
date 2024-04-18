<?php

namespace App\Controller;

use App\Service\ChocoblastService;
use App\Service\CommentaryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Commentary;
use App\Form\CommentaryType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentaryController extends AbstractController
{
    public function __construct(
        private readonly ChocoblastService $chocoblastService,
        private readonly CommentaryService $commentaryService
    ) {
    }

    #[Route('/commentary/{id}', name: 'app_commentary_all')]
    public function showCommentByChocoblast($id): Response
    {
        $comments = $this->commentaryService->findAllByChocoblastId($id);
        return $this->render('commentary/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/commentary/add/{id}', name: 'app_commentary_add')]
    public function create($id, Request $request): Response
    {
        $comment = new Commentary();
        $form = $this->createForm(CommentaryType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //récupération de l'utilisateur connecté
            $user = $this->getUser();
            $comment->setAuthor($user);
            $comment->setStatus(false);
            $comment->setChocoblast($this->chocoblastService->findOneBy($id));
            //ajout du commentaire en BDD
            $this->commentaryService->create($comment);
            //redirection vers la liste des chocoblasts
            return $this->redirectToRoute('app_chocoblast_all');
        }
        return $this->render('commentary/addCommentary.html.twig', [
            'form' => $form,
            'id_choco' => $id
        ]);
    }
}
