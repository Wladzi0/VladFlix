<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted("ROLE_FRIENDLY_USER")
 */
class ChoicePageController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator=$translator;
    }

    /**
     * @Route ("/change-locale", name="change_locale")
     */
    public function changeLocale(Request $request)
    {

    }
    /**
     * @Route("/select-pin", name="select_profile")
     */
    public function index(SessionInterface $session,Request $request, UserInterface $user, ProfileRepository $profileRepository): Response
    {

        dump($session->get('profileId'));
        $profiles = $profileRepository->findAllByUser($user);
        return $this->render('profiles/change_profile.html.twig', [
            'profiles' => $profiles
        ]);
    }

    /**
     * @Route("/addProfile", name="add_profile")
     */
    public function addProfile(Request $request, UserInterface $user, ProfileRepository $profileRepository): Response
    {

        $pin = $request->get('pin');
        $profile = new Profile();
        $formProfile = $this->createForm(ProfileType::class, $profile);
        $colorArray = ['51, 51, 51', '102, 102, 102', '153, 153, 153', '204, 204, 204',
            '153, 102, 102', '102, 51, 51', '204, 153, 153', '153, 51, 51', '204, 102, 102', '204, 51, 51',
            '51, 0, 0', '102, 0, 0', '153, 0, 0', '204, 0, 0', '255, 0, 0', '255, 51, 51', '255, 102, 102',
            '255, 153, 153', '255, 204, 204', '255, 51, 0', '204, 51, 0', '255, 102, 51', '204, 102, 51',
            '153, 51, 0', '255, 153, 102', '255, 102, 0', '153, 102, 51', '204, 153, 102', '102, 51, 0', '204, 102, 0',
            '255, 153, 51', '255, 204, 153', '255, 153, 0', '204, 1`53, 51', '153, 102, 0', '255, 204, 102', '204, 153, 0',
            '255, 204, 51', '255, 204, 0', '153, 153, 102', '102, 102, 51', '204, 204, 153', '153, 153, 51', '204, 204, 102', '204, 204, 51', '51, 51, 0', '102, 102, 0',
            '153, 153, 0', '204, 204, 0', '255, 255, 0', '255, 255, 51', '255, 255, 102', '255, 255, 153',
            '255, 255, 204', '204, 255, 0', '153, 204, 0', '204, 255, 51', '153, 204, 51', '102, 153, 0', '204, 255, 102', '153, 255, 0', '102, 153, 51',
            '153, 204, 102', '51, 102, 0', '102, 204, 0', '153, 255, 51', '204, 255, 153',
            '102, 255, 0', '102, 204, 51', '51, 153, 0', '153, 255, 102', '51, 204, 0', '102, 255, 51', '51, 255, 0',
            '102, 153, 102', '51, 102, 51', '153, 204, 153', '51, 153, 51', '102, 204, 102', '51, 204, 51', '0, 51, 0',
            '0, 102, 0', '0, 153, 0', '0, 204, 0', '0, 255, 0', '51, 255, 51', '102, 255, 102', '153, 255, 153',
            '204, 255, 204', '0, 255, 51', '0, 204, 51', '51, 255, 102', '51, 204, 102', '0, 153, 51', '102, 255, 153', '0, 255, 102',
            '51, 153, 102', '102, 204, 153', '0, 102, 51', '0, 204, 102', '51, 255, 153', '153, 255, 204', '0, 255, 153', '51, 204, 153', '0, 153, 102',
            '102, 255, 204', '0, 204, 153', '51, 255, 204', '0, 255, 204', '102, 153, 153', '51, 102, 102', '153, 204, 204', '51, 153, 153',
            '102, 204, 204', '51, 204, 204', '0, 51, 51', '0, 102, 102', '0, 153, 153', '0, 204, 204', '0, 255, 255',
            '51, 255, 255', '102, 255, 255', '153, 255, 255', '204, 255, 255', '0, 204, 255', '0, 153, 204',
            '51, 204, 255', '51, 153, 204', '0, 102, 153', '102, 204, 255', '0, 153, 255', '51, 102, 153', '102, 153, 204',
            '0, 51, 102', '0, 102, 204', '51, 153, 255', '153, 204, 255', '0, 102, 255', '51, 102, 204',
            '0, 51, 153', '102, 153, 255', '0, 51, 204', '51, 102, 255', '0, 51, 255',
            '102, 102, 153', '51, 51, 102', '153, 153, 204', '51, 51, 153', '102, 102, 204',
            '51, 51, 204', '0, 0, 51', '0, 0, 102', '0, 0, 153', '0, 0, 204', '0, 0, 255', '51, 51, 255', '102, 102, 255', '153, 153, 255', '204, 204, 255',
            '51, 0, 255', '51, 0, 204', '102, 51, 255', '102, 51, 204', '51, 0, 153', '153, 102, 255', '102, 0, 255',
            '102, 51, 153', '153, 102, 204', '51, 0, 102', '102, 0, 204', '153, 51, 255', '204, 153, 255', '153, 0, 255', '153, 51, 204',
            '102, 0, 153', '204, 102, 255', '153, 0, 204', '204, 51, 255', '204, 0, 255', '153, 102, 153', '102, 51, 102', '204, 153, 204', '153, 51, 153',
            '204, 102, 204', '204, 51, 204', '51, 0, 51', '102, 0, 102', '153, 0, 153', '204, 0, 204',
            '255, 0, 255', '255, 51, 255', '255, 102, 255', '255, 153, 255', '255, 204, 255', '255, 0, 204',
            '204, 0, 153', '255, 51, 204', '204, 51, 153', '153, 0, 102', '255, 102, 204', '255, 0, 153', '153, 51, 102',
            '204, 102, 153', '102, 0, 51', '204, 0, 102', '255, 51, 153', '255, 153, 204', '255, 0, 102',
            '204, 51, 102', '153, 0, 51', '255, 102, 153', '204, 0, 51', '255, 51, 102', '255, 0, 51',];

        $random = array_rand($colorArray);
        $randomColor = 'rgb(' . $colorArray[$random] . ')';
        $usersProfiles = $profileRepository->findAllByUser($user);

        $formProfile->handleRequest($request);
        if ($formProfile->isSubmitted() && $formProfile->isValid()) {

            $profile = $formProfile->getData();
            $nick = $formProfile->get('nickname')->getData();
            $profilePin = $formProfile->get('profilePin')->getData();
            $profile->setUser($user);

            foreach ($usersProfiles as $usersProfile) {

                if ($usersProfile->getNickname() === $nick) {

                    $request->getSession()
                        ->getFlashBag()
                        ->add('danger',('This nickname is already exists'));
                    $referer = $request->headers->get('referer');
                    return new RedirectResponse($referer);
                }
                while ($usersProfile->getBackgroundColor() === $randomColor) {
                    $random = array_rand($colorArray);
                    $randomColor = 'rgb(' . $colorArray[$random] . ')';
                }
            }

            $profile->setInterfaceLanguage("en");
            $profile->setPreferredLanguage("en");
            $profile->setPreferredAudio("en");
            $profile->setProfilePin($profilePin);
            $profile->setBackgroundColor($randomColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success',('Profile has been added successfully'));
            return $this->redirectToRoute('select_profile');
        }


        return $this->render('profiles/add_profile.html.twig', [
            'profileForm' => $formProfile->createView()
        ]);


    }

    /**
     * @Route("/enterPin", name="enter_pin", methods={"GET", "POST"})
     */
    public function enterPin(SessionInterface $session, Request $request, ProfileRepository $profileRepository): Response
    {
        $profileId = $request->get('profile');
        if ($profileId) {
            $profile = $profileRepository->find($profileId);
            $profilePin = $profile->getProfilePin();
            if ($profilePin === null) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'BOOM');
                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);

            } else {
                return $this->render('security/enterPinSub.html.twig', [
                    'profile' => $profileId]);
            }

        } else {
            return $this->render('security/enterPinAdd.html.twig');
        }

    }

    /**
     * @Route("/check-pin", name="check_sub_pin")
     */
    public function checkSubPin(TranslatorInterface $translator,Request $request, ProfileRepository $profileRepository, SessionInterface $session)
    {
        if($session->get('profileId')){
            $session->remove('profileId');
        }
        $profile = $request->get('profile');
        $pin = $request->get('pin');
        if(!$pin || !$profile){
            $message=$translator->trans('You forgot select your profile',null,null,'message.pl.yaml', 'pl');
            $request->getSession()
                    ->getFlashBag()
                    ->add('danger', $message);
                return $this->redirectToRoute('select_profile');
        }
        else{
        $profileDB=$profileRepository->find($profile);
        $profilePin=$profileDB->getProfilePin();
        $requestedData=array(
            'enteredPin'=>$pin,
            'profilePin'=>$profilePin);
        }
        if(!$this->isGranted("MAIN_ACCESS",$requestedData)){
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'Invalid PIN! Please try again');
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer);
        }
        else{

            $session->set('profileId',$profile);
            return $this->redirectToRoute('main_page');
        }

    }

}
