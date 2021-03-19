<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @IsGranted("ROLE_USER")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main_page")
     */
    public function index(Request $request, UserInterface $user,ProfileRepository $profileRepository,CategoryRepository $categoryRepository)
    {
        $pin=$request->get('pin');
        $profileId=$request->get('profile');

        if(!$pin || !$profileId){
            $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'You forgot to log in with your profile');
                return $this->redirectToRoute('select_profile');
        }
        $profile=$profileRepository->find($profileId);
        $profilePin=$profile->getPin();
        $dataProfile=array($pin,$profilePin);
        if(!$this->isGranted("SHOW",$dataProfile)){
//            throw new \Exception("Access denied :(");
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'Invalid PIN! Please try again');
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer);
        }



        $categories= $categoryRepository->findAll();
        $profiles =$profileRepository->findAllByUser($user);
        return $this->render('main_content/main_page.html.twig', [
            'profiles'=>$profiles,
            'categories'=>$categories
        ]);
    }

    /**
     * @Route("/all-in-Category", name="allInCategory")
     */
    public function allInCategory(Request $request,CategoryRepository $categoryRepository)
    {
        $category=$request->get('category');
        if($category){
            $AllFileResults=$categoryRepository->findAllByCategory($category);
        }
        return $this->render('main_content/allInCategory.html.twig', [
            'allResults'=>$AllFileResults
        ]);
    }


}