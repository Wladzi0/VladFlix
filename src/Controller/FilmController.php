<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FileRepository;
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
    public function AllFilmsFromCategory(Request $request, CategoryRepository $categoryRepository, FilmRepository $filmRepository)
    {
        $categoryRequest = $request->get('category');
        $categoryData = $categoryRepository->find($categoryRequest);
        $categories = $categoryRepository->findAll();
        $AllFilmsByCategory = $filmRepository->findAllByCategory($categoryRequest);
        return $this->render('films_content/allFilmsFromCategory.html.twig', [
            'category' => $categoryData,
            'categories' => $categories,
            'allFilmsByCategory' => $AllFilmsByCategory
        ]);
    }

    /**
     * @Route("/film/{filmId}", name="film_page", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function film(Request $request, FilmRepository $filmRepository,FileRepository $fileRepository)
    {
        $filmRequest=$request->get('filmId');
        $file=$fileRepository->findFile($filmRequest);
        $filmData=$filmRepository->find($filmRequest);

        return $this->render('films_content/film_page.html.twig', [
            'file'=>$file,
            'filmData' => $filmData
        ]);
    }
}