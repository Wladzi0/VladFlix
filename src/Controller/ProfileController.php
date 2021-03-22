<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_FRIENDLY_USER")
 *
 */
class ProfileController extends AbstractController
{
    /**
     * @Route ("/profile-menu", name="profileMenu")
     */
    public function profileMenu(SessionInterface $session, ProfileRepository $profileRepository)
    {
        $currentProfile=$session->get('profileId');
        $profileData=$profileRepository->find($currentProfile);

        return $this->render('profileMenu/settings.html.twig',[
            'profile'=>$profileData ]);
    }

    /**
     * @Route("/edit-profile-settings", name="editProfileSettings")
     */
    public function editSettings(SessionInterface $session,Request $request, ProfileRepository $profileRepository)
    {
        $currentProfile=$session->get('profileId');
        $profileData=$profileRepository->find($currentProfile);
        $profileForm=$this->createForm(EditProfileType::class,$profileData);
        $profileForm->handleRequest($request);
        if($profileForm->isSubmitted() && $profileForm->isValid()){

            $this->getDoctrine()->getManager()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your settings has been edited successfully ');


            return $this->redirectToRoute('profileMenu');

        }
        return $this->render('profileMenu/editSettings.html.twig',[

            'profileForm'=>$profileForm->createView() ]);

    }

    /**
     * @Route("/profile-logout", name="profileLogout")
     */
    public function profileLogout(Request $request, SessionInterface $session){
        $session->remove('profileId');
        return $this->redirectToRoute('select_profile');
    }
}
