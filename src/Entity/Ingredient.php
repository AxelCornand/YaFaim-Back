<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_ingredient", "get_recipe_ingredient", "get_name_ingredient", "get_favorites"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"get_ingredient", "get_recipe_ingredient", "get_name_ingredient", "get_favorites"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_ingredient", "get_favorites"})
     */
    private $expiration_date;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"get_ingredient", "get_favorites"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=RecipeIngredient::class, mappedBy="ingredient")
     */
    private $recipeIngredient;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of recipeIngredient
     */ 
    public function getRecipeIngredient()
    {
        return $this->recipeIngredient;
    }

    /**
     * Set the value of recipeIngredient
     *
     * @return  self
     */ 
    public function setRecipeIngredient($recipeIngredient)
    {
        $this->recipeIngredient = $recipeIngredient;

        return $this;
    }
}
