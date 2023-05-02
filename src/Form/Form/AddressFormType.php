<?php

namespace App\Form\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class AddressFormType extends AbstractType
{

    public function __construct(
        private readonly TranslatorInterface $translator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameOrNumber', TextType::class,[
                'label'=> $this->translator->trans('address.name-or-number'),
                'attr' => [
                    'placeholder' => $this->translator->trans('address.name-or-number'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('floor', NumberType::class,[
                'label'=> $this->translator->trans('address.floor'),
                'attr' => [
                    'placeholder' => $this->translator->trans('address.floor'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('postcode', TextType::class,[
                'label'=> $this->translator->trans('address.postcode'),
                'attr' => [
                    'placeholder' => $this->translator->trans('address.postcode'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('lineOne', TextType::class,[
                'label'=> $this->translator->trans('address.line-one'),
                'attr' => [
                    'placeholder' => $this->translator->trans('address.line-one'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('lineTwo', TextType::class,[
                'label'=> $this->translator->trans('address.line-two'),
                'required' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('address.line-two'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('city', TextType::class,[
                'label'=> $this->translator->trans('address.city'),
                'attr' => [
                    'placeholder' => $this->translator->trans('adddress.city'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('county', TextType::class,[
                'label'=> $this->translator->trans('address.county'),
                'required' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('address.county'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
            ])
            ->add('country', CountryType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('address.country'),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
                'autocomplete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
