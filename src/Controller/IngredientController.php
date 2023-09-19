<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Service\MySlugger;
use App\Form\IngredientType;
use App\Repository\RecipeRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="app_ingredient_index", methods={"GET"})
     */
    public function index(IngredientRepository $ingredientRepository): Response
    {
        // visual of the page in the back for the ingredients
        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ingredient_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IngredientRepository $ingredientRepository,MySlugger $mySlugger): Response
    {
        // creation of an instance of ingredient
        $ingredient = new Ingredient();
        // creation of the form
        $form = $this->createForm(IngredientType::class, $ingredient);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient->setSlug($mySlugger->slugify($ingredient->getName()));
            $ingredientRepository->add($ingredient, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the new ingredient
        return $this->renderForm('ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ingredient_show", methods={"GET"})
     */
    public function show(Ingredient $ingredient): Response
    {
        // visual to see one ingredient
        return $this->render('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ingredient_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository,MySlugger $mySlugger): Response
    {
        // creation of the form
        $form = $this->createForm(IngredientType::class, $ingredient);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient->setSlug($mySlugger->slugify($ingredient->getName()));
            $ingredientRepository->add($ingredient, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the edition of the ingredient
        return $this->renderForm('ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ingredient_delete", methods={"POST"})
     */
    public function delete(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository): Response
    {
        // recovery of the id and the token to delete the ingredient
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $ingredientRepository->remove($ingredient, true);
        }
        // returns to the path after delete
        return $this->redirectToRoute('app_ingredient_index', [], Response::HTTP_SEE_OTHER);
    }
}
