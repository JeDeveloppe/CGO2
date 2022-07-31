<?php

namespace App\Form;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class VilleAutocompleteField extends AbstractType
{

    private $cgo;

    public function __construct(Security $security)
    {
        $this->cgo = $security->getUser();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Ville::class,
            'placeholder' => 'Lieu de l\'intervention...',
            'choice_label' => function (Ville $ville) {
                return $ville->getName() . ' - ' . $ville->getPostalCode();
            },
            'searchable_fields' => ['name', 'postalCode'],
            'query_builder' => function (VilleRepository $villeRepository) {
                return $villeRepository->findVillesByDepartementsFromCgo($this->cgo);
            }
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
