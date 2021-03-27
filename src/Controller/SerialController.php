<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use App\Repository\SeasonRepository;
use App\Repository\SerialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class SerialController extends AbstractController
{
    /**
     * @Route("/all-serials-from-category", name="all_serials_from_category")
     */
    public function AllSerialsFromCategory(Request $request, CategoryRepository $categoryRepository,SerialRepository $serialRepository){

        $categoryRequest = $request->get('category');
        $categoryData=$categoryRepository->find($categoryRequest);
        $categories=$categoryRepository->findAll();
        $AllSerialsByCategory=$serialRepository->findAllByCategory($categoryRequest);
        return $this->render('serials_content/allSerialsFromCategory.html.twig', [
            'category'=>$categoryData,
            'categories'=> $categories,
            'allSerialsByCategory'=>$AllSerialsByCategory
        ]);
    }

    /**
     * @Route("/all-seasons-from-serial/{serial}", name="all_seasons_from_serial")
     */
    public function allSeasonsFromSerial(Request $request,SeasonRepository $seasonRepository,SerialRepository $serialRepository)
    {
        $serialId=$request->get('serial');
        $serial=$serialRepository->find($serialId);
        $allSeasonsFromSerial=$seasonRepository->findBySerial($serialId);
        return $this->render('serials_content/seasons_page.html.twig', [
            'serial'=>$serial,
            'seasons'=>$allSeasonsFromSerial
        ]);
    }
}