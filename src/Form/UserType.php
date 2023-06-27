<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    /**
     * Methode qui construit le formulaire
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse email'
                ],
            ])
            // checkbox

            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'choice_value' => function ($choice) {
                    return $choice;
                },
                
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => ' ms-2',
                ]
            ])
            
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Mot de passe'
                    ],
                    'required' => false,
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Répéter le mot de passe'
                    ],
                    'required' => false,
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    /**
     * Methode qui configure les options du formulaire
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
