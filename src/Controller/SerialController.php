<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
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
    public function AllFilmsByCategory(Request $request, CategoryRepository $categoryRepository,SerialRepository $serialRepository){

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
}