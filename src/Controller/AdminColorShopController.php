<?php

namespace App\Controller;

use App\Entity\ColorShop;
use App\Form\ColorShopType;
use App\Repository\ColorShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/color-shop')]
class AdminColorShopController extends AbstractController
{
    #[Route('/', name: 'app_color_shop_index', methods: ['GET'])]
    public function index(ColorShopRepository $colorShopRepository): Response
    {
        return $this->render('color_shop/index.html.twig', [
            'color_shops' => $colorShopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_color_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ColorShopRepository $colorShopRepository): Response
    {
        $colorShop = new ColorShop();
        $form = $this->createForm(ColorShopType::class, $colorShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colorShopRepository->add($colorShop, true);

            return $this->redirectToRoute('app_color_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('color_shop/new.html.twig', [
            'color_shop' => $colorShop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_color_shop_show', methods: ['GET'])]
    public function show(ColorShop $colorShop): Response
    {
        return $this->render('color_shop/show.html.twig', [
            'color_shop' => $colorShop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_color_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ColorShop $colorShop, ColorShopRepository $colorShopRepository): Response
    {
        $form = $this->createForm(ColorShopType::class, $colorShop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colorShopRepository->add($colorShop, true);

            return $this->redirectToRoute('app_color_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('color_shop/edit.html.twig', [
            'color_shop' => $colorShop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_color_shop_delete', methods: ['POST'])]
    public function delete(Request $request, ColorShop $colorShop, ColorShopRepository $colorShopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$colorShop->getId(), $request->request->get('_token'))) {
            $colorShopRepository->remove($colorShop, true);
        }

        return $this->redirectToRoute('app_color_shop_index', [], Response::HTTP_SEE_OTHER);
    }
}
