<?php

namespace App\Form;

use App\Entity\Diet;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Ingredient;

use App\Entity\RecipeIngredient;
use App\Form\RecipeIngredientType;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // 
        $builder
            // add a form field with the name in text
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            // add a form field with the instruction in longtext
            ->add('instruction', TextareaType::class, [
                'label' => 'Instruction',
            ])
            // add a form field with the picture in url format
            ->add('poster', UrlType::class, [
                'label' => 'Image',
                'attr' => [
                    'placeholder' => 'par ex. https://...',
                ],
            ])
            // add a form field with the preparation time in integer
            ->add('preptime', IntegerType::class, [
                'label' => 'Temps de préparation',
                'help' => 'Un nombre strictement positif.',
                'empty_data' => 0,
            ])
            // add a form field with the cooking time in integer
            ->add('cooktime', IntegerType::class, [
                'label' => 'Temps de cuisson',
                'help' => 'Un nombre strictement positif.',
                'empty_data' => 0,
            ])
            // add a form field with the persons number in integer
            ->add('nbperson', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'help' => 'Un nombre strictement positif.',
                'empty_data' => 0,
            ])
            // add a form field with the difficulty in integer
            ->add('difficulty', IntegerType::class, [
                'label' => 'Difficulté de préparation',
                'help' => 'Un nombre strictement positif.',
            ])
            // add a form field with the ingredients list in a collection (show all ingredients and multiple choice)
            ->add('recipeingredient', CollectionType::class, [
                'label' => 'Liste ingrédient',
                'attr' => ['class' => 'inject'],
                'entry_type' => RecipeIngredientType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            // add a form field with the category name in checkbox (single choice)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'mapped' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
            ])
            // add a form field with the diet name in checkbox (multiple choice)
            ->add('diet', EntityType::class, [
                'class' => Diet::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
