<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\FilmRepository;
use App\Repository\SerialRepository;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class MainController extends AbstractController
{
    private  $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="main_page")
     */
    public function index(SessionInterface $session, CategoryRepository $categoryRepository, LoggerInterface $logger)
    {


        if (!$session->get('profileId')) {
            return $this->redirectToRoute('select_profile');
        }
        $allSerialsAndFilms = $categoryRepository->findallSerialsAndFilms();

        return $this->render('main_content/main_page.html.twig', [
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
    /**
     * @Route ("/change-user-language", name="change_user_language")
     */
    public function changeUserLanguage(Request $request, Session $session): RedirectResponse
    {
        $user= $this->security->getUser();
        if ($changedLanguage = $request->get('userLanguage')) {
            $user->setDefaultLanguage($changedLanguage);
            $this->getDoctrine()->getManager()->flush();
            $session->set('_locale', $user->getDefaultLanguage());

        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

}