<?php

namespace App\Form\Form;

use App\Entity\Review;
use App\Form\Autocomplete\AddressAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReviewFormType extends AbstractType
{

    public function __construct(
        private readonly TranslatorInterface $translator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('durationOfStayInMonths', TextType::class, [
                'label'=> $this->translator->trans('duration-of-stay-in-months'),
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('buildingRating', RangeType::class, [
                'help'=> $this->translator->trans('building-rating-explainer'),
                'row_attr' => [
                    'data-controller' => 'rating',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => '0.5',
                    'class' => 'rating'
                ]
            ])
            ->add('managementRating', RangeType::class, [
                'help'=> $this->translator->trans('management-rating-explainer'),
                'row_attr' => [
                    'data-controller' => 'rating',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => '0.5',
                    'class' => 'rating'
                ]
            ])
            ->add('locationRating', RangeType::class, [
                'help'=> $this->translator->trans('location-rating-explainer'),
                'row_attr' => [
                    'data-controller' => 'rating',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => '0.5',
                    'class' => 'rating'
                ]
            ])->add('priceRating', RangeType::class, [
                'help'=> $this->translator->trans('price-rating-explainer'),
                'row_attr' => [
                    'data-controller' => 'rating',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => '0.5',
                    'class' => 'rating'
                ]
            ])
            ->add('transportRating', RangeType::class, [
                'help'=> $this->translator->trans('transport-rating-explainer'),
                'row_attr' => [
                    'data-controller' => 'rating',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => '0.5',
                    'class' => 'rating'
                ]
            ])
            ->add('explanation', TextareaType::class, [
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('address', AddressAutocompleteField::class, [
                'row_attr' => [
                    'class' => 'm-0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
