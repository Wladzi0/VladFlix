<?php

namespace App\Controller;

use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_USER")
 *
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile-settings", name="profileSettings")
     */
    public function settings(Request $request, ProfileRepository $profileRepository)
    {
        $currentProfile=$request->get('profile');

            $profileData=$profileRepository->find($currentProfile);
           return $this->render('profileMenu/settings.html.twig',[
                'profile'=>$profileData ]);

    }
}
