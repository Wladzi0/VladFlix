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
    public function index(SessionInterface $session, Request $request, UserInterface $user,ProfileRepository $profileRepository,FilmRepository $filmRepository,CategoryRepository $categoryRepository)
    {
        $sessionProfile=$session->get('profileId');
        if(!$sessionProfile){
                return $this->redirectToRoute('select_profile');
        }
        $categories= $categoryRepository->findAll();
//        foreach($categories as $category){
//            $filmsSerialsByCat= $filmRepository->findAllByCategory($category);
//            if ($filmsSerialsByCat) {
//                {
//                    $results['content'] = $this->getRealEntity($filmsSerialsByCat);
//                }
//
//            }
//        }

        return $this->render('main_content/main_page.html.twig', [
//            'results'=>$results,
            'categories'=>$categories
        ]);
    }

//    public function getRealEntity($filmsSerials)
//    {
//        foreach ($filmsSerials as $filmSerial ) {
//            $realEntities[$filmSerial->getId()] = [$filmSerial->getName(),$filmSerial->getCountry(), $filmSerial->getYear()];
//        }
//        return $realEntities;
//    }

    /**
     * @Route("/all-in-Category", name="all_in_category")
     */
    public function allInCategory(Request $request,CategoryRepository $categoryRepository,FilmRepository $filmRepository,SerialRepository $serialRepository)
    {

        $categoryRequest=$request->get('category');
        $categoryData=$categoryRepository->find($categoryRequest);
        if($categoryRequest){
            $AllResults=$filmRepository->findAllByCategory($categoryRequest);
//            if ($AllResults) {
//                {
//                    $results['films'] = $this->getRealEntity($AllResults);
//                }
//                $AllResults=serial->findAllByCategory($categoryRequest);
        }
//        }
        dump($AllResults);
        return $this->render('main_content/allInCategory.html.twig', [
            'category'=> $categoryData,
            'allResults'=>$AllResults
        ]);
    }

    /**
     * @Route("/all-Films-Serials", name="all_films_serials")
     */
    public function allFilms(CategoryRepository $categoryRepository,SessionInterface $session,Request $request,FilmRepository $filmRepository,SerialRepository $serialRepository): Response
    {
        $typeSearch=$request->get('typeSearch');
        $categories=$categoryRepository->findAll();
        if($typeSearch==="films"){
            $films=$filmRepository->findAll();
            return $this->render('films_content/films_page.html.twig',[
                'films'=>$films,
                'categories'=>$categories
            ]);
        }
        else{
            $serials=$serialRepository->findAll();
            return $this->render('serials_content/serials_page.html.twig',[
                'serials'=>$serials,
                'categories'=>$categories
            ]);
        }
    }

}