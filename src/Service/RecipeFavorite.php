<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RecipeFavorite
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Recipe $recipe, User $user)
    {
        $user->addRecipe($recipe);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(Recipe $recipe, User $user)
    {
        if ($user->getRecipes()->contains($recipe)) {
            $user->removeRecipe($recipe);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}