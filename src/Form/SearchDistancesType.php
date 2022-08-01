<?php

namespace App\Form;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use App\Form\VilleAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchDistancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville', VilleAutocompleteField::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('interventionLatitude', NumberType::class, [
                'label' => 'Latitude (entre 50 et 42):',
                'required' => false,
                'mapped' => false
            ])
            ->add('interventionLongitude', NumberType::class, [
                'label' => 'Longitude (entre -5 et 8):',
                'required' => false,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Calculer',
                'attr' => [
                    'class' => 'btn btn-success mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cgo' => [],
            'data_class' => Ville::class,
        ]);
    }
}
