<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\FileRepository;
use App\Repository\ProfileRepository;
use App\Repository\SeasonRepository;
use App\Repository\SerialRepository;
use App\Repository\TimeDataRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class SerialController extends AbstractController
{
    /**
     * @Route("/all-serials-from-category/{category}", name="all_serials_from_category")
     */
    public function AllSerialsFromCategory(Request $request, CategoryRepository $categoryRepository, SerialRepository $serialRepository)
    {

        $categoryRequest = $request->get('category');
        $categoryData = $categoryRepository->find($categoryRequest);
        $categories = $categoryRepository->findAll();
        $AllSerialsByCategory = $serialRepository->findAllByCategory($categoryRequest);
        return $this->render('serials_content/allSerialsFromCategory.html.twig', [
            'category' => $categoryData,
            'categories' => $categories,
            'allSerialsByCategory' => $AllSerialsByCategory
        ]);
    }

    /**
     * @Route("/serial/{serialId}", name="all_seasons_from_serial")
     */
    public function allSeasonsFromSerial(SessionInterface $session, Request $request, SeasonRepository $seasonRepository, SerialRepository $serialRepository)
    {

        $serialId = $request->get('serialId');
        $serial = $serialRepository->find($serialId);
        $dataToCheck = array(
            'profileAgeCategory' => $session->get('age'),
            'contentAgeCategory' => $serial->getAgeCategory()
        );
        if (!$this->isGranted("SHOW_ACCESS", $dataToCheck)) {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'You do not have access to this content :(');
            return $this->redirectToRoute('main_page');
        }

        $allSeasonsFromSerial = $seasonRepository->findBySerial($serialId);
        return $this->render('serials_content/seasons_page.html.twig', [
            'serial' => $serial,
            'seasons' => $allSeasonsFromSerial
        ]);
    }

    /**
     * @Route ("/serial/{serialId}/all-episodes-of-season/{seasonId}", name="all_episodes_of_season")
     */
    public function showEpisodes(SessionInterface $session, Request $request, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository, SerialRepository $serialRepository)
    {
        $seasonId = $request->get('seasonId');
        $serial = $serialRepository->findSerialBySeason($seasonId);
        $dataToCheck = array(
            'profileAgeCategory' => $session->get('age'),
            'contentAgeCategory' => $serial->getAgeCategory()
        );
        if (!$this->isGranted("SHOW_ACCESS", $dataToCheck)) {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'You do not have access to this content :(');
            return $this->redirectToRoute('main_page');
        }

        $season = $seasonRepository->find($seasonId);
        $serial = $serialRepository->findSerialBySeason($seasonId);
        $episodes = $episodeRepository->findFromSeason($seasonId);

        return $this->render('serials_content/seasonEpisodes.html.twig', [
            'serial' => $serial,
            'episodes' => $episodes,
            'season' => $season
        ]);
    }

    /**
     * @Route("/serial/{serialId}/season/{seasonId}/", name="show_episode", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function showEpisodeDetail(TimeDataRepository $timeDataRepository, SerialRepository $serialRepository, Request $request, EpisodeRepository $episodeRepository, FileRepository $fileRepository, SessionInterface $session, ProfileRepository $profileRepository)
    {
        $episodeId = $request->get('episodeId');
        $seasonId = $request->get('seasonId');
        $serial = $serialRepository->find($request->get('serialId'));
        $dataToCheck = array(
            'profileAgeCategory' => $session->get('age'),
            'contentAgeCategory' => $serial->getAgeCategory()
        );
        if (!$this->isGranted("SHOW_ACCESS", $dataToCheck)) {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'You do not have access to this content :(');
            return $this->redirectToRoute('main_page');
        }

        $profile = $profileRepository->find($session->get('profileId'));
        $episodeData = $episodeRepository->find($episodeId);
        $lastEpisode = $episodeRepository->lastEpisodeOfSeason($seasonId);
        if ($episodeId > $lastEpisode->getId()) {
            return $this->redirectToRoute('all_seasons_from_serial', ['serialId' => $serial->getId()]);
        }
        $episodeFile = $fileRepository->findFileOfEpisode($episodeId);
        $videoData = $timeDataRepository->findByFileAndProfile($episodeFile->getId(), $profile->getId());
        if ($videoData === null) {
            $curVideoData = "0";
        } else {
            $curVideoData = $videoData->getCurTime();
        }
        $file = $fileRepository->findFileOfEpisode($episodeId);
        return $this->render('serials_content/episode_page.html.twig', [
            'episodeData' => $episodeData,
            'serialId' => $serial->getId(),
            'seasonId' => $seasonId,
            'curVideoData' => $curVideoData,
            'profile' => $profile,
            'file' => $file

        ]);
    }
}