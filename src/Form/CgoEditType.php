<?php

namespace App\Form;

use App\Entity\Cgo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CgoEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom:'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email:'
            ])
            ->add('password', TextType::class, [
                'label' => 'Mot de passe:',
                'attr' => [
                    'readOnly' => true
                ]
            ])
            ->add('new_password', TextType::class, [
                'mapped' => false,
                'label' => 'Nouveau mot de passe:',
                'required' => false
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles:'
            ]);
        // ->add('roles', ChoiceType::class, [
        //     'choices' => [
        //         'ROLE_USER' => 'Utilisateur',
        //         'ROLE_ADMIN' => 'Administrateur'
        //     ]
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cgo::class,
        ]);
    }
}
