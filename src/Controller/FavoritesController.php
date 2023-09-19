<?php

namespace App\Controller;


use App\Entity\Recipe;
use App\Service\RecipeFavorite;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/favorites/", name="app_api_")
 */
class FavoritesController extends AbstractController
{

    private $recipeFavorite;

    public function __construct(RecipeFavorite $recipeFavorite)
    {
        $this->recipeFavorite = $recipeFavorite;
    }

    /**
     * @Route("add/{id}", name="add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function add(int $id, RecipeRepository $recipeRepository): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $recipe = $recipeRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        if (!$recipe) {
            return new JsonResponse(['error' => 'recette non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->recipeFavorite->add($recipe, $user);

        return new JsonResponse(['success' => JsonResponse::HTTP_OK]);
    }

    /**
     * @Route("remove/{id}", name="remove", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function remove(int $id, Recipe $recipe, RecipeRepository $recipeRepository): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $recipe = $recipeRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        if (!$recipe) {
            return new JsonResponse(['error' => 'recette non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->recipeFavorite->remove($recipe, $user);


        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("favoriteList", name="favorites", methods={"GET"})
     */
    public function favoriteJson(): Response
    {
        // Search for one user in the BDD by the token
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Get the favorite recipes for the user
        $favoriteRecipes = $user->getRecipes()->toArray();

        // Return Json of the user with their favorite recipes to the front
        return $this->json(
            // Information of the user with their favorite recipe convert in Json
            [
                'user' => $user,
                'favoriteRecipes' => $favoriteRecipes,
            ],
            // The status code of create 202
            202,
            // The header
            [],
            // Serialization groups
            ['groups' => ['get_favorites']]
        );
    }
}
