<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function add(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retrieves recipes for a given ingredient (DQL)
     * @param int[] $ingredientIds
     *
     * @return Recipe[]
     */
    public function findByIngredientName(array $ingredientNames, EntityManagerInterface $entityManager): array
    {
        $recipes = [];
        // Research for each request
        foreach ($ingredientNames as $ingredientName) {
            $query = $entityManager->createQuery('SELECT r
                FROM App\Entity\Recipe r
                INNER JOIN App\Entity\RecipeIngredient ri WITH r.id = ri.recipe
                INNER JOIN App\Entity\Ingredient i WITH i.id = ri.ingredient
                WHERE i.name LIKE :ingredientName');
    
            $query->setParameter('ingredientName', '%'.$ingredientName.'%');
    
            // Execute the query and get the result
            $result = $query->getResult();
    
            // If $recipes is empty, add the result
            if (empty($recipes)) {
                $recipes = $result;
            } else {
                // Remove recipes that do not have the current ingredient
                foreach ($recipes as $key => $recipe) {
                    if (!in_array($recipe, $result)) {
                        unset($recipes[$key]);
                    }
                }
            }
        }

        return array_values($recipes);
    }

    /**
     * Retrieves favorites for a user
     */
    public function findFavoritesByUser(EntityManagerInterface $entityManager, int $userId)
    {
        $query = $entityManager->createQuery('
            SELECT r
            FROM App\Entity\Recipe r
            JOIN r.users u
            WHERE u.id = :userId
        ');
    
        $query->setParameter('userId', $userId);
    
        return $query->getResult();
    }
}
