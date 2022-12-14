<?php

namespace App\Form;

use App\Entity\Shop;
use App\Entity\TypeOfShop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du centre:'
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude (entre 50 et 42):'
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude (entre -5 et 8):'
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type de centre:',
                'class' => TypeOfShop::class,
                'choice_label' => 'type'
            ])
            ->add('isOnLine', ChoiceType::class, [
                'choices' => [
                    'En ligne' => 1,
                    'Hors ligne' => 0
                ],
                'label' => 'Statut:'
            ])
            //->add('cgo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
