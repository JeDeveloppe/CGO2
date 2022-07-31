<?php

namespace App\Form;

use App\Entity\Cgo;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementsOfCgoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departements', EntityType::class,[
                'label' => false,
                'class' => Departement::class,
                'choice_label' => 'departement_code',
                'choice_label' => function (Departement $departement) {
                    return $departement->getDepartementCode() . ' : ' . $departement->getDepartementNomUppercase();
                },
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cgo::class,
        ]);
    }
}
