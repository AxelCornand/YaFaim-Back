<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_recipe","get_recipe_for_ingredient", "get_favorites", "get_users"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"get_recipe","get_recipe_for_ingredient", "get_favorites"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"get_recipe","get_recipe_for_ingredient", "get_favorites"})
     */
    private $instruction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_recipe","get_recipe_for_ingredient", "get_favorites"})
     */
    private $poster;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get_recipe", "get_favorites"})
     */
    private $preptime;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get_recipe", "get_favorites"})
     */
    private $cooktime;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbperson;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get_recipe", "get_favorites"})
     */
    private $difficulty;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_recipe", "get_favorites"})
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Diet::class, inversedBy="recipes")
     * @Groups({"get_recipe", "get_recipe_diet","get_recipe_for_ingredient", "get_favorites"})
     */
    private $diet;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="recipes")
     * 
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="recipes")
     * @Groups({"get_recipe", "get_recipe_category","get_recipe_for_ingredient", "get_favorites"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=RecipeIngredient::class, mappedBy="recipe",cascade={"persist"})
     * @Groups({"get_recipe", "get_recipe_ingredient", "get_name_ingredient", "get_favorites"})
     */
    private $recipeIngredient;

    public function __construct()
    {
        $this->diet = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->recipeIngredient = new ArrayCollection();
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

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(string $instruction): self
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getPreptime(): ?int
    {
        return $this->preptime;
    }

    public function setPreptime(int $preptime): self
    {
        $this->preptime = $preptime;

        return $this;
    }

    public function getCooktime(): ?int
    {
        return $this->cooktime;
    }

    public function setCooktime(int $cooktime): self
    {
        $this->cooktime = $cooktime;

        return $this;
    }

    public function getNbperson(): ?int
    {
        return $this->nbperson;
    }

    public function setNbperson(int $nbperson): self
    {
        $this->nbperson = $nbperson;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

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
     * @return Collection<int, Diet>
     */
    public function getDiet(): Collection
    {
        return $this->diet;
    }

    public function addDiet(Diet $diet): self
    {
        if (!$this->diet->contains($diet)) {
            $this->diet[] = $diet;
        }

        return $this;
    }

    public function removeDiet(Diet $diet): self
    {
        $this->diet->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredient(): Collection
    {
        return $this->recipeIngredient;
    }

    public function addRecipeIngredient(RecipeIngredient $oneRecipeIngredient): self
    {
        if (!$this->recipeIngredient->contains($oneRecipeIngredient)) {
            $this->recipeIngredient[] = $oneRecipeIngredient;
            $oneRecipeIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $oneRecipeIngredient): self
    {
        if ($this->recipeIngredient->removeElement($oneRecipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($oneRecipeIngredient->getRecipe() === $this) {
                $oneRecipeIngredient->setRecipe(null);
            }
        }

        return $this;
    }
}