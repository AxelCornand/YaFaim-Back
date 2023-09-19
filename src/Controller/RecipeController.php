<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Service\MySlugger;
use App\Entity\RecipeIngredient;
use App\Repository\DietRepository;
use App\Repository\RecipeRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeIngredientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/back/recipe")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="app_recipe_index", methods={"GET"})
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        // visual of the page in the back for the recipes
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="app_recipe_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RecipeRepository $recipeRepository, MySlugger $mySlugger): Response
    {
        // creation of an instance of recipe
        $recipe = new Recipe();
        // creation of the form
        $form = $this->createForm(RecipeType::class, $recipe);
        // store answers in the form
        $form->handleRequest($request);
         // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setSlug($mySlugger->slugify($recipe->getName()));
            $recipeRepository->add($recipe, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the new recipe
        return $this->renderForm('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_recipe_show", methods={"GET"})
     */
    public function show(Recipe $recipe): Response
    {
        // visual to see one recipe
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_recipe_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Recipe $recipe, RecipeRepository $recipeRepository,MySlugger $mySlugger): Response
    {
        // creation of the form
        $form = $this->createForm(RecipeType::class, $recipe);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setSlug($mySlugger->slugify($recipe->getName()));
            $recipeRepository->add($recipe, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the edition of the recipe
        return $this->renderForm('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_recipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        // recovery of the id and the token to delete the recipe
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $recipeRepository->remove($recipe, true);
        }
        // returns to the path after delete
        return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
