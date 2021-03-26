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
class FilmController extends AbstractController
{
    /**
     * @Route("/all-films-from-category", name="all_films_from_category")
     */
     public function AllFilmsByCategory(Request $request, CategoryRepository $categoryRepository,FilmRepository $filmRepository){
     $categoryRequest = $request->get('category');
     $categoryData=$categoryRepository->find($categoryRequest);
     $categories=$categoryRepository->findAll();
     $AllFilmsByCategory=$filmRepository->findAllByCategory($categoryRequest);
     return $this->render('films_content/allFilmsFromCategory.html.twig', [
         'category'=>$categoryData,
         'categories'=> $categories,
         'allFilmsByCategory'=>$AllFilmsByCategory
     ]);
 }
}