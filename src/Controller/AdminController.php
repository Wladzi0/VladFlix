<?php

namespace App\Controller;


use App\Entity\File;
use App\Entity\Film;
use App\Form\FileType;
use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function welcomePage()
    {
       return $this->render('admin/welcome_page.html.twig');
    }
    /**
     * @Route("/add-new-film", name="add_new_film")
     */
    public function addFilm(Request $request)
    {
        $fileOfFilm= new File();
        $film = new Film();
        $formFilm= $this->createForm(FilmType::class, $film);
        $formFile= $this->createForm(FileType::class, $fileOfFilm);
        $formFile->handleRequest($request);
        $formFilm->handleRequest($request);
//        dump($formFilm);
//        dump($formFile);
//        die;
        if ($formFilm->isSubmitted() && $formFilm->isValid()) {

                $file = $formFile->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($file);
            $film=$formFilm->getData();
            $film->setFile($file);
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Film is added!');
            return $this->redirectToRoute('admin');
        }
//            if (!$this->isGranted("ADD_ACCESS", $userPin)) {
//                $request->getSession()
//                    ->getFlashBag()
//                    ->add('danger', 'User`s PIN is incorrect. You cannot add profile!');
//                $referer = $request->headers->get('referer');
//                return new RedirectResponse($referer);
//            }

        return $this->render('admin/add_new_film.html.twig',[
                'formFilm' => $formFilm->createView(),
                'formFile' => $formFile->createView()
            ]
        );
    }
}