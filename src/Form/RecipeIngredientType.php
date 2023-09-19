<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            // add a form field with the quantity in integer
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'help' => 'Un nombre strictement positif.',
                'empty_data' => 0,
            ])
            // add a form field with the measure in text
            ->add('measure', TextType::class, [
                'label' => 'Mesure',
                'help' => 'gr, ml, etc...',
            ])
            // add a form field with the ingredient name in checkbox (single choice)
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
