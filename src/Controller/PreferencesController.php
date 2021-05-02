<?php

namespace App\Controller;


use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class PreferencesController extends AbstractController
{
    /**
     * @Route("/profile/preferences", name="profilePreferences")
     */
    public function index(SessionInterface $session, Request $request, ProfileRepository $profileRepository)
    {
        $profileId = $session->get('profileId');
        $profile = $profileRepository->find($profileId);
        if ($selectedSubtitles = $request->get('subtitles')) {
            $profile->setPreferredLanguage($selectedSubtitles);

        }
        if ($selectedAudio = $request->get('audio')) {
            $profile->setPreferredAudio($selectedAudio);

        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($profile);
        $em->flush();

        return new JsonResponse(['success' => 1]);
    }

}