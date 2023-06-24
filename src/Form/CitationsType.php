<?php

namespace App\Form;

use App\Entity\Auteurs;
use App\Entity\Citations;
use App\Repository\AuteursRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CitationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('citation', TextType::class, [
                'label' => 'Citation',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Citation'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('explication', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Explication',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
            ])
            ->add('auteurs', EntityType::class, [
                'class' => Auteurs::class,
                'choice_label' => 'auteur',
                'label' => 'Auteur',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'placeholder' => 'Choisir un auteur',
                'query_builder' => function (AuteursRepository $auteursRepository) {
                    return $auteursRepository->createQueryBuilder('a')
                        ->orderBy('a.auteur', 'ASC')
                    ;
                }
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Valider'
                ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citations::class,
        ]);
    }
}
