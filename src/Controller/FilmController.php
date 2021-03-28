<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\SerialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        $AllFilmsFromCategory = $filmRepository->findAllFromCategory($categoryRequest);
        return $this->render('films_content/allFilmsFromCategory.html.twig', [
            'category' => $categoryData,
            'categories' => $categories,
            'allFilmsFromCategory' => $AllFilmsFromCategory
        ]);
    }

    /**
     * @Route("/film/{filmId}", name="film_page", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function film(SessionInterface $session,Request $request, FilmRepository $filmRepository,FileRepository $fileRepository,ProfileRepository $profileRepository)
    {
        $filmRequest=$request->get('filmId');
        $profile=$profileRepository->find($session->get('profileId'));
        dump($profile);
        $file=$fileRepository->findFile($filmRequest);
        $filmData=$filmRepository->find($filmRequest);

        return $this->render('films_content/film_page.html.twig', [
            'profile'=>$profile,
            'file'=>$file,
            'filmData' => $filmData
        ]);
    }
}