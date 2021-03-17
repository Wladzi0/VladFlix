<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/main", name="main_page", methods={"POST"})
     */
    public function index(Request $request, UserInterface $user,ProfileRepository $profileRepository,CategoryRepository $categoryRepository): Response
    {
            $categories= $categoryRepository->findAll();
//        $pin=$request->get('pin');
//        if($pin) {
//        $this->denyAccessUnlessGranted(VoterPage::SHOW,$pin);
//            }
//            else{
//                $request->getSession()
//                    ->getFlashBag()
//                    ->add('danger', 'PIN is not correct');
//                return $this->redirectToRoute('enter_pin');
//            }

        $profiles =$profileRepository->findAllByUser($user);
        return $this->render('main_content/main_page.html.twig', [
            'profiles'=>$profiles,
            'categories'=>$categories
        ]);
    }

    /**
     * @Route("/all-in-Category/{id}", name="allInCategory", methods={"GET", "POST"})
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