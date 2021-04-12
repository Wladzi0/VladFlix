<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
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
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(SessionInterface $session, CategoryRepository $categoryRepository)
    {
        if (!$session->get('profileId')) {
            return $this->redirectToRoute('select_profile');
        }
        $categories = $categoryRepository->findAll();
        $allSerialsAndFilms = $categoryRepository->findallSerialsAndFilms();

        return $this->render('main_content/main_page.html.twig', [
            'categories' => $categories,
            'allSerialsAndFilms' => $allSerialsAndFilms,
        ]);
    }


    /**
     * @Route("/all-Films-Serials", name="all_films_serials")
     */
    public function allFilms(CategoryRepository $categoryRepository, SessionInterface $session, Request $request, FilmRepository $filmRepository, SerialRepository $serialRepository): Response
    {
        if (!$session->get('profileId')) {
            return $this->redirectToRoute('select_profile');
        }
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