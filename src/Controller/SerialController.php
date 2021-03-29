<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\SeasonRepository;
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
class SerialController extends AbstractController
{
    /**
     * @Route("/all-serials-from-category", name="all_serials_from_category")
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
     * @Route("/all-seasons-from-serial/{serial}", name="all_seasons_from_serial")
     */
    public function allSeasonsFromSerial(Request $request, SeasonRepository $seasonRepository, SerialRepository $serialRepository)
    {
        $serialId = $request->get('serial');
        $serial = $serialRepository->find($serialId);
        $allSeasonsFromSerial = $seasonRepository->findBySerial($serialId);
        return $this->render('serials_content/seasons_page.html.twig', [
            'serial' => $serial,
            'seasons' => $allSeasonsFromSerial
        ]);
    }

    /**
     * @Route ("/show-all-episodes-of-season/{seasonId}", name="all_episodes_of_season")
     * @param Request $request
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param FileRepository $fileRepository
     */
    public function showEpisodes(Request $request, SeasonRepository $seasonRepository,EpisodeRepository $episodeRepository,SerialRepository $serialRepository)
    {
        $seasonId=$request->get('seasonId');
        $season=$seasonRepository->find($seasonId);
        $serial=$serialRepository->findSerialBySeason($seasonId);
        $episodes=$episodeRepository->findFromSeason($seasonId);

        return $this->render('serials_content/seasonEpisodes.html.twig', [
            'serial'=>$serial,
            'episodes' => $episodes,
            'season' => $season
        ]);
    }

    /**
     * @Route("/show-episode/{episodeId}", name="show_episode")
     * @param Request $request
     * @param FileRepository $fileRepository
     */
    public function showEpisodeDetail(Request $request,EpisodeRepository $episodeRepository,FileRepository $fileRepository,SessionInterface $session,ProfileRepository $profileRepository)
    {
        $episodeId=$request->get('episodeId');
        $profile=$profileRepository->find($session->get('profileId'));
        $episodeData=$episodeRepository->find($episodeId);
        $file = $fileRepository->findFileOfEpisode($episodeId);
        return $this->render('serials_content/episode_page.html.twig', [
            'episodeData' => $episodeData,
            'profile'=>$profile,
            'file'=>$file
        ]);
    }
}