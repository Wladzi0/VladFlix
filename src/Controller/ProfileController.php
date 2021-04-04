<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_FRIENDLY_USER")
 *
 */
class ProfileController extends AbstractController
{
    /**
     * @Route ("/profile-menu", name="profile_menu")
     */
    public function profileMenu(SessionInterface $session, ProfileRepository $profileRepository)
    {
        if ($currentProfile = $session->get('profileId')) {
            $profileData = $profileRepository->find($currentProfile);
        } else {
            return $this->redirectToRoute('select_profile');
        }

        return $this->render('profileMenu/settings.html.twig', [
            'profile' => $profileData]);
    }

    /**
     * @Route("/edit-profile-settings", name="edit_profile_settings")
     */
    public function editSettings(SessionInterface $session, Request $request, ProfileRepository $profileRepository)
    {
        if ($currentProfile = $session->get('profileId')) {
            $profileData = $profileRepository->find($currentProfile);
            $profileForm = $this->createForm(EditProfileType::class, $profileData);
            $profileForm->handleRequest($request);
            if ($profileForm->isSubmitted() && $profileForm->isValid()) {

                $this->getDoctrine()->getManager()->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Your settings has been edited successfully ');


                return $this->redirectToRoute('profile_menu');
            }
        } else {
            return $this->redirectToRoute('select_profile');
        }
        return $this->render('profileMenu/editSettings.html.twig', [

            'profileForm' => $profileForm->createView()]);

    }

    /**
     * @Route("/change-profile-language",name="change_profile_language")
     */
    public function changeProfileLanguage(SessionInterface $session, Request $request, ProfileRepository $profileRepository)
    {
        $profileId = $session->get('profileId');
        $profile = $profileRepository->find($profileId);
        if ($changedLanguage = $request->get('interfaceLanguage')) {
            $profile->setInterfaceLanguage($changedLanguage);
            $this->getDoctrine()->getManager()->flush();
        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);

    }

}
