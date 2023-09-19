<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // 
        $builder
            // add a form field with the email in email format
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            // add a form field with the firstname in text
            ->add('firstname', TextType::class, [
                'label' => 'Prenom',
            ])
            // add a form field with the lastname in text
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            // add a form field with the role in checkbox (multiple choice)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Membre' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôle(s)',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
            ])
            // add a form field with the password hash in text
            ->add('password', TextType::class, [
                'help' => 'Make sure it\'s at least 8 characters including a number and a lowercase letter and a special character.',
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-+]).{8,}$/'),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
