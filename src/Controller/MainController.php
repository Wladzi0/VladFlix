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
    public function index(SessionInterface $session, Request $request, UserInterface $user,ProfileRepository $profileRepository,CategoryRepository $categoryRepository)
    {      dump($sessionProfile=$session->get('profileId'));
        $sessionProfile=$session->get('profileId');
        if($sessionProfile){
            $categories= $categoryRepository->findAll();
            return $this->render('main_content/main_page.html.twig', [
                'categories'=>$categories
            ]);

        }
        else {
            $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'You forgot to select your profile');
                return $this->redirectToRoute('select_profile');
        }
    }

    /**
     * @Route("/all-in-Category", name="all_in_category")
     */
    public function allInCategory(Request $request,CategoryRepository $categoryRepository)
    {
        $category=$request->get('category');
        if($category){
            $AllFileResults=$categoryRepository->findAllByCategory($category);
        }
        return $this->render('main_content/allInCategory.html.twig', [
            'allResults'=>$AllFileResults
        ]);
    }

    /**
     * @Route("/all-Films-Serials", name="all_films_serials")
     */
    public function allFilms(SessionInterface $session,Request $request,FilmRepository $filmRepository,SerialRepository $serialRepository): Response
    {
        $typeSearch=$request->get('typeSearch');
        if($typeSearch==="films"){
            $films=$filmRepository->findAll();
            return $this->render('films_content/films_page.html.twig',[
                'films'=>$films
            ]);
        }
        else{
            $serials=$serialRepository->findAll();
            return $this->render('serials_content/serials_page.html.twig',[
                'serials'=>$serials
            ]);
        }
    }

}