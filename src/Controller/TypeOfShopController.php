<?php

namespace App\Controller;

use App\Entity\TypeOfShop;
use App\Form\TypeOfShopType;
use App\Repository\ColorShopRepository;
use App\Repository\TypeOfShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type-of-shop')]
class TypeOfShopController extends AbstractController
{
    #[Route('/', name: 'app_type_of_shop_index', methods: ['GET'])]
    public function index(TypeOfShopRepository $typeOfShopRepository): Response
    {
        return $this->render('type_of_shop/index.html.twig', [
            'type_of_shops' => $typeOfShopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_of_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeOfShopRepository $typeOfShopRepository, ColorShopRepository $colorShopRepository): Response
    {
        $typeOfShop = new TypeOfShop();
        $form = $this->createForm(TypeOfShopType::class, $typeOfShop);
        $form->handleRequest($request);
        $colors = $colorShopRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfShopRepository->add($typeOfShop, true);

            return $this->redirectToRoute('app_type_of_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_shop/new.html.twig', [
            'type_of_shop' => $typeOfShop,
            'form' => $form,
            'colors' => $colors
        ]);
    }

    #[Route('/{id}', name: 'app_type_of_shop_show', methods: ['GET'])]
    public function show(TypeOfShop $typeOfShop): Response
    {
        return $this->render('type_of_shop/show.html.twig', [
            'type_of_shop' => $typeOfShop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_of_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeOfShop $typeOfShop, TypeOfShopRepository $typeOfShopRepository, ColorShopRepository $colorShopRepository): Response
    {
        $form = $this->createForm(TypeOfShopType::class, $typeOfShop);
        $form->handleRequest($request);
        $colors = $colorShopRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfShopRepository->add($typeOfShop, true);

            return $this->redirectToRoute('app_type_of_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_shop/edit.html.twig', [
            'type_of_shop' => $typeOfShop,
            'form' => $form,
            'colors' => $colors
        ]);
    }

    #[Route('/{id}', name: 'app_type_of_shop_delete', methods: ['POST'])]
    public function delete(Request $request, TypeOfShop $typeOfShop, TypeOfShopRepository $typeOfShopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeOfShop->getId(), $request->request->get('_token'))) {
            $typeOfShopRepository->remove($typeOfShop, true);
        }

        return $this->redirectToRoute('app_type_of_shop_index', [], Response::HTTP_SEE_OTHER);
    }
}
