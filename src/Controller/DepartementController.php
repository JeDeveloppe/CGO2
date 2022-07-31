<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\CgoRepository;
use App\Form\DepartementsOfCgoType;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cgo/departements')]
class DepartementController extends AbstractController
{

    #[Route('/', name: 'app_listeDepartementsOfCgo', methods: ['GET', 'POST'])]
    public function listeDepartementsOfCgo(Request $request, CgoRepository $cgoRepository, Security $security): Response
    {
        $cgo = $security->getUser();
        
        $form = $this->createForm(DepartementsOfCgoType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cgoRepository->add($cgo, true);

            $this->addFlash('success', 'Changements pris en charge!');

            return $this->redirectToRoute('app_listeDepartementsOfCgo', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/departement/liste_departements.html.twig', [
            'cgo' => $cgo,
            'form' => $form,
        ]);
    }

}
