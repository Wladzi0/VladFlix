<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use App\Security\Voter\VoterPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class ChoicePageController extends AbstractController
{
    /**
     * @Route("/", name="select_profile")
     */
    public function index(Request $request, UserInterface $user,ProfileRepository $profileRepository): Response
    {
        $profiles =$profileRepository->findAllByUser($user);
        return $this->render('profiles/change_profile.html.twig', [
            'profiles'=>$profiles
        ]);
    }

    /**
     * @Route("/addProfile", name="add_profile", methods={"POST"})
     */
    public function addProfile(Request $request, UserInterface $user, ProfileRepository $profileRepository):Response
    {
        $pin=$request->get('pin');
        if($pin) {
            if($pin===$user->getPin()){
                $this->denyAccessUnlessGranted("ROLE_USER");
            }
            else{
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'PIN is not correct');
                return $this->redirectToRoute('enter_pin');
            }


        }
        $profile= new Profile();
        $formProfile=$this->createForm(ProfileType::class, $profile);
        $colorArray=['51, 51, 51', '102, 102, 102', '153, 153, 153', '204, 204, 204',
            '153, 102, 102', '102, 51, 51', '204, 153, 153', '153, 51, 51', '204, 102, 102', '204, 51, 51',
            '51, 0, 0', '102, 0, 0', '153, 0, 0', '204, 0, 0', '255, 0, 0', '255, 51, 51', '255, 102, 102',
            '255, 153, 153', '255, 204, 204', '255, 51, 0', '204, 51, 0', '255, 102, 51', '204, 102, 51',
            '153, 51, 0', '255, 153, 102', '255, 102, 0', '153, 102, 51', '204, 153, 102', '102, 51, 0', '204, 102, 0',
            '255, 153, 51', '255, 204, 153', '255, 153, 0', '204, 153, 51', '153, 102, 0', '255, 204, 102', '204, 153, 0',
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
            '204, 102, 153', '102, 0, 51', '204, 0, 102', '255, 51, 153', '255, 153, 204','255, 0, 102',
            '204, 51, 102', '153, 0, 51', '255, 102, 153', '204, 0, 51', '255, 51, 102', '255, 0, 51',];

        $random=array_rand($colorArray);
        $randomColor='rgb('.$colorArray[$random].')';
        $usersProfiles=$profileRepository->findAllByUser($user);

        $formProfile -> handleRequest($request);
        if($formProfile->isSubmitted() && $formProfile->isValid()){
            $profile=$formProfile->getData();
            $nick = $formProfile->get('nickname')->getData();
            $profile->setUser($user);


            foreach($usersProfiles as $usersProfile) {

                if ($usersProfile->getNickname() === $nick) {

                    $request->getSession()
                        ->getFlashBag()
                        ->add('danger', 'Nickname "' . $nick . '" is already exists');
                    return $this->redirectToRoute('enter_pin');
                }
                while ($usersProfile->getBackgroundColor() === $randomColor) {
                    $random = array_rand($colorArray);
                    $randomColor = 'rgb(' . $colorArray[$random] . ')';
                }
            }

            $profile->setBackgroundColor($randomColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
            ->add('success', 'Profile has been added successfully');
            return $this->redirectToRoute('select_profile');
        }


        return $this->render('profiles/add_profile.html.twig', [
            'profileForm'=> $formProfile->createView()
        ]);


    }

    /**
     * @Route("/enterPin", name="enter_pin", methods={"GET", "POST"})
     */
    public function enterPin(Request $request): Response
    {
        $profile=$request->get('profile');
        if($profile){
            return $this->render('security/enterPinSub.html.twig',[
                'profile'=>$profile]);
        }
        else{
        return $this->render('security/enterPinAdd.html.twig');
        }

    }

}
