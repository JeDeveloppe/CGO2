<?php

namespace App\Controller\Site;

use App\Service\CgoService;
use Doctrine\ORM\Mapping\Entity;
use App\Form\SearchDistancesType;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    #[Route('/cgo/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    #[Route('/cgo/calcul-distances', name: 'app_calcul_distances')]
    public function calculDistances(Security $security, Request $request, CgoService $cgoService, ShopRepository $shopRepository): Response
    {
        $cgo = $security->getUser();

        //on verifie si des departements sont attachés au cgo
        $departements = $cgo->getDepartements();
        //si aucun de rattaché
        if(count($departements) == 0){
            $this->addFlash('warning', 'Le CGO ne semble pas avoir de département rattachés...');
            return $this->redirectToRoute('app_listeDepartementsOfCgo', [], Response::HTTP_SEE_OTHER);
        }


        //on cherche les centres rattachés au cgo
        $shops = $shopRepository->findBy(['cgo' => $cgo, 'isOnLine' => true], ['name' => 'ASC']);
        //si aucun centre en ligne ou créé
        if($shops == null){
            $this->addFlash('warning', 'Le CGO ne semble pas avoir de centre rattachés...');
            return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
        }


        $form = $this->createForm(SearchDistancesType::class, null, ['cgo' => $cgo]);
        $form->handleRequest($request);

        $datas = [];
        $shops = [];

        if($form->isSubmitted() && $form->isValid()) {

            $shops = $shopRepository->findBy(['cgo' => $cgo, 'isOnLine' => true], ['name' => 'ASC']);

            if(!empty($form->get('interventionLongitude')->getData()) && !empty($form->get('interventionLatitude')->getData()) && !empty($form->get('ville')->getData())){
                $this->addFlash('warning', 'Choisir la ville OU la position GPS !');
                return $this->redirectToRoute('app_calcul_distances', [], Response::HTTP_SEE_OTHER);
            }

            if(!empty($form->get('ville')->getData())){
                $depannage = $form->get('ville')->getData();

                $interventionLongitude = $depannage->getLongitude();
                $interventionLatitude = $depannage->getLatitude();

            }else if(!empty($form->get('interventionLongitude')->getData()) && !empty($form->get('interventionLatitude')->getData() )){
                $interventionLongitude = $form->get('interventionLongitude')->getData();
                $interventionLatitude = $form->get('interventionLatitude')->getData() ;
            }else{
                $this->addFlash('warning', 'Aucun lieu de séléctionner !');
                return $this->redirectToRoute('app_calcul_distances', [], Response::HTTP_SEE_OTHER);
            }

            foreach($shops as $shop){

                array_push($datas, $cgoService->getDistancesBeetweenDepannageAndShop($interventionLatitude,$interventionLongitude,$shop));

            }

            //on tri le tableau en fonction de la distance la plus courte
            array_multisort(array_column($datas, 'distance'), SORT_ASC, $datas);
        }

        return $this->render('site/calcul_distance.html.twig', [
            'form' => $form->createView(),
            'datas' => $datas
        ]);
    }
}
