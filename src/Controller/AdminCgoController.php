<?php

namespace App\Controller;

use App\Entity\Cgo;
use App\Form\CgoEditType;
use App\Form\CgoCreationType;
use App\Repository\CgoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

#[Route('/admin/cgo')]
class AdminCgoController extends AbstractController
{
    #[Route('/', name: 'app_admin_cgo_index', methods: ['GET'])]
    public function index(CgoRepository $cgoRepository): Response
    {
        return $this->render('admin_cgo/index.html.twig', [
            'cgos' => $cgoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_cgo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CgoRepository $cgoRepository): Response
    {
        $cgo = new Cgo();
        $form = $this->createForm(CgoCreationType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cgoRepository->add($cgo, true);

            return $this->redirectToRoute('app_admin_cgo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cgo/new.html.twig', [
            'cgo' => $cgo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_cgo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cgo $cgo, CgoRepository $cgoRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(CgoEditType::class, $cgo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($form->get('new_password')->getData())) {
                $new_password = $userPasswordHasher->hashPassword(
                    $cgo,
                    $form->get('new_password')->getData()
                );
                $cgo->setPassword($new_password);
            }

            $cgoRepository->add($cgo, true);

            $this->addFlash('success', 'CGO modifié avec succès!');
            return $this->redirectToRoute('app_admin_cgo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cgo/edit.html.twig', [
            'cgo' => $cgo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_cgo_delete', methods: ['POST'])]
    public function delete(Request $request, Cgo $cgo, CgoRepository $cgoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cgo->getId(), $request->request->get('_token'))) {
            $cgoRepository->remove($cgo, true);
        }

        return $this->redirectToRoute('app_admin_cgo_index', [], Response::HTTP_SEE_OTHER);
    }
}
