<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\SerialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(FilmRepository $filmRepository, SerialRepository $serialRepository, SessionInterface $session, Request $request, UserInterface $user, ProfileRepository $profileRepository, CategoryRepository $categoryRepository)
    {
        if (!$sessionProfile = $session->get('profileId')) {
            return $this->redirectToRoute('select_profile');
        }
        $categories = $categoryRepository->findAll();
        $allSerialsAndFilms= $categoryRepository->findallSerialsAndFilms();

        return $this->render('main_content/main_page.html.twig', [
            'categories' => $categories,
            'allSerialsAndFilms' => $allSerialsAndFilms,
        ]);
    }

    /**
     * @Route("/all-films-serials-from-category", name="all_films_serials_from_category")
     */
    public function allFilmsSerialsFromCategory(Request $request, CategoryRepository $categoryRepository, FilmRepository $filmRepository, SerialRepository $serialRepository)
    {

        $categoryRequest = $request->get('category');
        $categoryData = $categoryRepository->find($categoryRequest);
        $categories = $categoryRepository->findAll();
        if ($categoryRequest) {
            $AllResults = $filmRepository->findAllByBYCategory($categoryRequest);

        }

        return $this->render('main_content/allFromCategory.html.twig', [
            'categories' => $categories,
            'category' => $categoryData,
            'allResults' => $AllResults
        ]);
    }

    /**
     * @Route("/all-Films-Serials", name="all_films_serials")
     */
    public function allFilms(ProfileRepository $profileRepository, CategoryRepository $categoryRepository, SessionInterface $session, Request $request, FilmRepository $filmRepository, SerialRepository $serialRepository): Response
    {
        $typeSearch = $request->get('typeSearch');
        $categories = $categoryRepository->findAll();

        if ($typeSearch === "films") {

            $films = $filmRepository->findAll();

            return $this->render('films_content/films_page.html.twig', [
                'films' => $films,
                'categories' => $categories
            ]);
        } else {
            $serials = $serialRepository->findAll();
            return $this->render('serials_content/serials_page.html.twig', [
                'serials' => $serials,
                'categories' => $categories
            ]);
        }
    }

}