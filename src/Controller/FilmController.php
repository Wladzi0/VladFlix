<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\SerialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/all-films-from-category/{category}", name="all_films_from_category")
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
    public function film(SessionInterface $session, Request $request, FilmRepository $filmRepository, FileRepository $fileRepository, ProfileRepository $profileRepository)
    {
        $profile = $profileRepository->find($session->get('profileId'));
        $filmRequest = $request->get('filmId');

        $filmData = $filmRepository->find($filmRequest);
        $dataToCheck=array(
          'profileAgeCategory'=>$profile->getAge(),
          'contentAgeCategory'=>  $filmData->getAgeCategory()
        );


        if (!$this->isGranted("SHOW_ACCESS", $dataToCheck)) {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'You do not have access to this content :(');
            return $this->redirectToRoute('main_page');
        }
        $file = $fileRepository->findFileOfFilm($filmRequest);
        return $this->render('films_content/film_page.html.twig', [
            'profile' => $profile,
            'file' => $file,
            'filmData' => $filmData
        ]);
    }
}