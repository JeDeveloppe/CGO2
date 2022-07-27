<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/cgo/shop')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'app_shop_index', methods: ['GET'])]
    public function index(ShopRepository $shopRepository, Security $security): Response
    {
        $cgo = $security->getUser();

        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findBy(['cgo' => $cgo]),
        ]);
    }

    #[Route('/new', name: 'app_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShopRepository $shopRepository, Security $security): Response
    {
        $cgo = $security->getUser();
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $shop->setCgo($cgo);
            $shopRepository->add($shop, true);

            $this->addFlash('success', 'Nouveau centre rattaché!');

            return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shop/new.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shop_show', methods: ['GET'])]
    public function show(Shop $shop): Response
    {
        return $this->render('shop/show.html.twig', [
            'shop' => $shop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shopRepository->add($shop, true);

            $this->addFlash('success', 'Centre mis à jour!');

            return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shop_delete', methods: ['POST'])]
    public function delete(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shop->getId(), $request->request->get('_token'))) {
            $shopRepository->remove($shop, true);
        }

        return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
    }
}
