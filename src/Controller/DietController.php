<?php

namespace App\Controller;

use App\Entity\Diet;
use App\Form\DietType;
use App\Repository\DietRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/diet")
 */
class DietController extends AbstractController
{
    /**
     * @Route("/", name="app_diet_index", methods={"GET"})
     */
    public function index(DietRepository $dietRepository): Response
    {
        // visual of the page in the back for the diets
        return $this->render('diet/index.html.twig', [
            'diets' => $dietRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_diet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DietRepository $dietRepository): Response
    {
        // creation of an instance of diet
        $diet = new Diet();
        // creation of the form
        $form = $this->createForm(DietType::class, $diet);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $dietRepository->add($diet, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the new diet
        return $this->renderForm('diet/new.html.twig', [
            'diet' => $diet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diet_show", methods={"GET"})
     */
    public function show(Diet $diet): Response
    {
        return $this->render('diet/show.html.twig', [
            'diet' => $diet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_diet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Diet $diet, DietRepository $dietRepository): Response
    {
        // creation of the form
        $form = $this->createForm(DietType::class, $diet);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $dietRepository->add($diet, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the edition of the diet
        return $this->renderForm('diet/edit.html.twig', [
            'diet' => $diet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diet_delete", methods={"POST"})
     */
    public function delete(Request $request, Diet $diet, DietRepository $dietRepository): Response
    {
        // recovery of the id and the token to delete the category
        if ($this->isCsrfTokenValid('delete'.$diet->getId(), $request->request->get('_token'))) {
            $dietRepository->remove($diet, true);
        }
        // returns to the path after delete
        return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
    }
}
