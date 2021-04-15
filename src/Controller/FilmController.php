<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\TimeDataRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
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
    private $startVideoLogger;
    public function __construct(loggerInterface $startVideoLogger){
        $this->startVideoLogger=$startVideoLogger;
    }
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
     * @Route("/film", name="film_page", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function film(TimeDataRepository $timeDataRepository, SessionInterface $session, Request $request, FilmRepository $filmRepository, FileRepository $fileRepository, ProfileRepository $profileRepository)
    {

        if (!$session->get('profileId')) {
            return $this->redirectToRoute('select_profile');
        }

        $profile = $profileRepository->find($session->get('profileId'));
        $filmRequest = $request->get('filmId');
        $file = $fileRepository->findFileOfFilm($filmRequest);
        $videoData = $timeDataRepository->findByFileAndProfile($file->getId(), $profile->getId());
        if ($videoData === null) {
            $curVideoData = "0";
        } else {
            $curVideoData = $videoData->getCurTime();
        }
        $filmData = $filmRepository->find($filmRequest);
        $dataToCheck = array(
            'profileAgeCategory' => $profile->getAge(),
            'contentAgeCategory' => $filmData->getAgeCategory()
        );
        if (!$this->isGranted("SHOW_ACCESS", $dataToCheck)) {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'You do not have access to this content :(');
            return $this->redirectToRoute('main_page');
        }
        $file = $fileRepository->findFileOfFilm($filmRequest);
        return $this->render('films_content/film_page.html.twig', [
            'curVideoData' => $curVideoData,
            'profile' => $profile,
            'file' => $file,
            'filmData' => $filmData
        ]);

    }

    /**
     * @Route("/log-start-video", name="startVideo")
     */
    public function filmLog(Request $request,FilmRepository $filmRepository, SessionInterface $session): Response
    {
        $film=$filmRepository->find($request->get('filmId'));
        $this->startVideoLogger->log(LogLevel::INFO,'Video started',['id'=>$film->getId(),'title'=>$film->getName(),'profileId'=>$session->get('profileId')]);
        return new Response();
    }

}