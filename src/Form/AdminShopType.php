<?php

namespace App\Form;

use App\Entity\Cgo;
use App\Entity\Shop;
use App\Entity\TypeOfShop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('latitude')
            ->add('longitude')
            ->add('type', EntityType::class, [
                'label' => 'Type de centre:',
                'class' => TypeOfShop::class,
                'choice_label' => 'name'
            ])
            ->add('isOnLine', ChoiceType::class, [
                'choices' => [
                    'En ligne' => 1,
                    'Hors ligne' => null
                ]
            ])
            ->add('cgo', EntityType::class, [
                'class' => Cgo::class,
                'choice_label' => 'name',
                'placeholder' => 'Sera rattaché au CGO de...'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}