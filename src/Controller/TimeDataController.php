<?php

namespace App\Controller;

use App\Entity\TimeData;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\ProfileRepository;
use App\Repository\SeasonRepository;
use App\Repository\SerialRepository;
use App\Repository\TimeDataRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class TimeDataController extends AbstractController
{
    /**
     * @Route ("/time-data-file-saving", name="saving")
     */
    public function timeDataSaving(Request $request, FileRepository $fileRepository, ProfileRepository $profileRepository, TimeDataRepository $timeDataRepository, SessionInterface $session): Response
    {

        $filmOrEpisodeId = $request->get('filmOrEpisodeId');
        $isFinished = $request->get('isFinished');
        if($isFinished==="false"){
            $isFinished=false;
        }
        else{
            $isFinished=true;
        }
        $curTime = $request->get('curTime');
        $isSerial = $request->get('isSerial');
        if ($isSerial === "false") {
            $file = $fileRepository->findFileOfFilm($filmOrEpisodeId);
        } else {
            $file = $fileRepository->findFileOfEpisode($filmOrEpisodeId);
        }
        $profile = $profileRepository->find($session->get('profileId'));
        $curVideoData = $timeDataRepository->findByFileAndProfile($file->getId(), $profile->getId());
        if (!$curVideoData) {
            $videoData = new TimeData();
            $videoData->setIsFinished($isFinished);
            $videoData->setCurTime($curTime);
            $videoData->addFile($file);
            $videoData->addProfile($profile);
            $em = $this->getDoctrine()->getManager();
            $em->persist($videoData);
            $em->flush();
        } else {
            $curVideoData->setIsFinished($isFinished);
            $curVideoData->setCurTime($curTime);
            $curVideoData->addFile($file);
            $curVideoData->addProfile($profile);
            $em = $this->getDoctrine()->getManager();
            $em->persist($curVideoData);
            $em->flush();

        }

        return new Response();
    }
}