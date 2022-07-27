<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\AdminShopType;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/shop')]
class AdminShopController extends AbstractController
{
    #[Route('/', name: 'app_admin_shop_index', methods: ['GET'])]
    public function index(ShopRepository $shopRepository): Response
    {
        return $this->render('admin_shop/index.html.twig', [
            'shops' => $shopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShopRepository $shopRepository): Response
    {
        $shop = new Shop();
        $form = $this->createForm(AdminShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shopRepository->add($shop, true);

            return $this->redirectToRoute('app_admin_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_shop/new.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_shop_show', methods: ['GET'])]
    public function show(Shop $shop): Response
    {
        return $this->render('admin_shop/show.html.twig', [
            'shop' => $shop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        $form = $this->createForm(AdminShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shopRepository->add($shop, true);

            return $this->redirectToRoute('app_admin_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_shop_delete', methods: ['POST'])]
    public function delete(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shop->getId(), $request->request->get('_token'))) {
            $shopRepository->remove($shop, true);
        }

        return $this->redirectToRoute('app_admin_shop_index', [], Response::HTTP_SEE_OTHER);
    }
}
