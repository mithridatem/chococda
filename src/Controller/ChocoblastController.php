<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ChocoblastService;
use App\Form\ChocoblastType;
use App\Entity\Chocoblast;

class ChocoblastController extends AbstractController
{
    #[Route('/chocoblast/add', name: 'app_chocoblast_add')]
    public function create(
        Request $request,
        ChocoblastService $chocoblastService
    ): Response {

        $chocoblast =new Chocoblast();
        //création du formulaire
        $form = $this->createForm(ChocoblastType::class, $chocoblast);
        //récupération de la requête
        $form->handleRequest($request);
        //test si le formulaire est submit
        if($form->isSubmitted() && $form->isValid()) {
            try {
                //ajout du chocoblast en BDD
                $chocoblast->setStatus(false);
                $chocoblastService->create($chocoblast);
            } catch (\Throwable $th) {
                $this->addFlash("danger", $th->getMessage());
            }
        }
        return $this->render('chocoblast/addChocoblast.html.twig', [
            'formulaire' => $form,
        ]);
    }

    #[Route('/chocoblast/all', name:'app_chocoblast_all')]
    public function showAllChocoblast(ChocoblastService $chocoblastService):Response 
    {
        $chocoblasts = $chocoblastService->findAll();

        return $this->render('chocoblast/showAllChocoblast.html.twig', [
            'chocoblasts' => $chocoblasts,
        ]);
    }
}
