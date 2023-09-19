<?php

namespace App\Entity;

use App\Repository\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

    /**
 * @ORM\Entity(repositoryClass=RecipeIngredientRepository::class)
 */

class RecipeIngredient
{

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get_recipe_ingredient", "get_favorites"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"get_recipe_ingredient", "get_favorites"})
     */
    private $measure;

    /**
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="recipeIngredient", cascade={"persist"})
     */
    private $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="recipeIngredient", cascade={"persist"})
     * @Groups({"get_recipe_ingredient", "get_name_ingredient", "get_favorites"})
     */
    private $ingredient;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    public function setMeasure(string $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get the value of recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set the value of recipe
     *
     * @return  self
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get the value of ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set the value of ingredient
     *
     * @return  self
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }
}
