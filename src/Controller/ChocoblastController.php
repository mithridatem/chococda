<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ChocoblastService;
use App\Form\ChocoblastType;
use App\Entity\Chocoblast;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ChocoblastController extends AbstractController
{
    public function __construct(
        private readonly ChocoblastService $chocoblastService
    ) {
    }

    #[Route('/chocoblast/add', name: 'app_chocoblast_add')]
    public function create(
        Request $request,
    ): Response {

        $chocoblast = new Chocoblast();
        //création du formulaire
        $form = $this->createForm(ChocoblastType::class, $chocoblast);
        //récupération de la requête
        $form->handleRequest($request);
        //test si le formulaire est submit
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //ajout du chocoblast en BDD
                $chocoblast->setStatus(false);
                $this->chocoblastService->create($chocoblast);
                $this->addFlash("Success", "Le chocoblast a été ajouté");
            } catch (\Throwable $th) {
                $this->addFlash("danger", $th->getMessage());
            }
        }
        return $this->render('chocoblast/addChocoblast.html.twig', [
            'formulaire' => $form,
        ]);
    }

    #[Route('/chocoblast/all', name: 'app_chocoblast_all')]
    public function showAllChocoblast(): Response
    {
        $chocoblasts = $this->chocoblastService->findActiveOrNot(true);

        return $this->render('chocoblast/showAllChocoblast.html.twig', [
            'chocoblasts' => $chocoblasts,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/chocoblast/all/inactive', name: 'app_chocoblast_all_inactive')]
    public function showAllChocoblastInactive(): Response
    {
        $chocoblasts = $this->chocoblastService->findActiveOrNot(false);

        return $this->render('chocoblast/showAllChocoblastInactive.html.twig', [
            'chocoblasts' => $chocoblasts,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/chocoblast/active/{id}', name: 'app_chocoblast_active')]
    public function activeChocoblast($id): Response
    {
        $chocoblast = $this->chocoblastService->findOneBy($id);
        $chocoblast->setStatus(true);
        $this->chocoblastService->update($chocoblast);
        return $this->redirectToRoute('app_chocoblast_all_inactive');
    }

    #[Route('/chocoblast/top/auteur', name:'app_chocoblast_top_auteur')]
    public function topAuthor():Response
    {
        $topAuthor = $this->chocoblastService->getCountChocoblastAuthor();
        $json = $this->json($topAuthor);
        return $this->render('chocoblast/topAuteur.html.twig', [
            'topAuthor'=> $json->getContent(),
        ]);
    }

    #[Route('/chocoblast/top/cible', name:'app_chocoblast_top_cible')]
    public function topTarget():Response
    {
        $topTarget = $this->chocoblastService->getCountChocoblastTarget();
        $json = $this->json($topTarget);
        return $this->render('chocoblast/topTarget.html.twig', [
            'topTarget'=> $json->getContent(),
        ]);
    }
    #[Route('/chocoblast/top', name:'app_chocoblast_top')]
    public function top():Response
    {
        return $this->render('chocoblast/topGraph.html.twig');
    }
}
