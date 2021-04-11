<?php

namespace App\Controller;


use App\Entity\Episode;
use App\Entity\File;
use App\Entity\Film;
use App\Entity\Season;
use App\Entity\Serial;
use App\Form\EpisodeType;
use App\Form\FileType;
use App\Form\FilmType;
use App\Form\SeasonType;
use App\Form\SerialType;
use App\Repository\EpisodeRepository;
use App\Repository\FileRepository;
use App\Repository\FilmRepository;
use App\Repository\SeasonRepository;
use App\Repository\SerialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;


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
        $fileOfFilm = new File();
        $film = new Film();
        $formFilm = $this->createForm(FilmType::class, $film);
        $formFile = $this->createForm(FileType::class, $fileOfFilm);
        $formFile->handleRequest($request);
        $formFilm->handleRequest($request);

        if ($formFilm->isSubmitted() && $formFilm->isValid()) {

            $file = $formFile->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $film = $formFilm->getData();
            $film->setFile($file);
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Film is added!');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/add_new_film.html.twig', [
                'formFilm' => $formFilm->createView(),
                'formFile' => $formFile->createView()
            ]
        );
    }

    /**
     * @Route("/add-new-serial", name="add_new_serial")
     */
    public function addSerial(Request $request)
    {
        $serial = new Serial();
        $formSerial = $this->createForm(SerialType::class, $serial);

        $formSerial->handleRequest($request);

        if ($formSerial->isSubmitted() && $formSerial->isValid()) {

            $serialData = $formSerial->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($serialData);
            $em->flush();

            return $this->redirectToRoute("add_new_season", array(
                'serial' => $serialData->getId()
            ));
        }

        return $this->render('admin/adding_of_serial/add_new_serial.html.twig', [
                'formSerial' => $formSerial->createView()
            ]
        );
    }

    /**
     * @Route("/add-new-season", name="add_new_season")
     */
    public function addNewSeason(Request $request, SerialRepository $serialRepository)
    {

        $episodeButton = false;
        if ($reqButton = $request->get('episodeButton')) {
            $episodeButton = $reqButton;
        }
        $serialId = $request->get('serial');
        $serial = $serialRepository->find($serialId);
        $season = new Season();
        $formSeason = $this->createForm(SeasonType::class, $season);
        $formSeason->handleRequest($request);
        if ($formSeason->isSubmitted() && $formSeason->isValid()) {
            $seasonData = $formSeason->getData();
            $seasonData->setSerial($serial);
            $em = $this->getDoctrine()->getManager();
            $em->persist($seasonData);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Season is added to ' . $seasonData->getName() . '!');
            return $this->redirectToRoute('add_new_season', array(
                'serial' => $serialId,
                'episodeButton' => true,
            ));
        }
        return $this->render('admin/adding_of_serial/add_new_season.html.twig', [
            'formSeason' => $formSeason->createView(),
            'episodeButton' => $episodeButton,
            'serial' => $serialId
        ]);
    }

    /**
     * @Route("/add-new-episode-file", name="add_new_episode_file")
     */
    public function addNewEpisode(Request $request, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository)
    {
        $serialId = $request->get('serial');
        $episode = new Episode();
        $file = new File();
        $formEpisode = $this->createForm(EpisodeType::class, $episode, array('bySerial' => $serialId));
        $formFile = $this->createForm(FileType::class, $file);
        $formFile->handleRequest($request);
        $formEpisode->handleRequest($request);
        if ($formEpisode->isSubmitted() && $formEpisode->isValid()) {
            $file = $formFile->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $episodeData = $formEpisode->getData();
            $episodeData->setFile($file);
            $em = $this->getDoctrine()->getManager();
            $em->persist($episodeData);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Episode "' . $episodeData->getName() . '" is added !');
            return $this->redirectToRoute('add_new_episode_file', array(
                'serial' => $serialId
            ));
        }
        return $this->render('admin/adding_of_serial/add_new_episode_file.html.twig', [
                'formEpisodeFile' => $formEpisode->createView(),
                'formFile' => $formFile->createView(),
                'serial' => $serialId
            ]
        );
    }

    /**
     * @Route("/list-of-all-films", name="list_of_all_films")
     */
    public function showAllFilms(EntityManagerInterface $em, FileRepository $fileRepository, Request $request, PaginatorInterface $paginator)
    {
        $dql = 'SELECT f FROM App\Entity\Film f';
        $query = $em->createQuery($dql);
        $files = $fileRepository->findAll();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)

        );
        return $this->render('admin/serial_and_film_lists/list_of_all_films.html.twig', [
            'films' => $pagination
        ]);
    }

    /**
     * @Route("/list-of-all-serials", name="list_of_all_serials")
     */
    public function showAllSerials(FilmRepository $filmRepository)
    {
        $films = $filmRepository->findAll();

        return $this->render('admin/serial_and_film_lists/list_of_all_serials.html.twig', [
            'films' => $films
        ]);
    }

    /**
     * @Route("/{serialId}/show-film-details", name="show_serial_details")
     */
    public function showSerialDetails(Request $request, Serial $serial): Response
    {
        return $this->render('admin/show_serial_details.html.twig', [
            'serial' => $serial
        ]);
    }

    /**
     * @Route("/{id}/edit-film-details", name="edit_film_details", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editFilmDetails(FileRepository $fileRepository, Request $request, Film $film, FilmRepository $filmRepository)
    {
        $formFilm = $this->createForm(FilmType::class, $film);
        $fileOfFilm = $fileRepository->findFileOfFilm($request->get('id'));
        $formFile = $this->createForm(FileType::class, $fileOfFilm);
        $formFilm->handleRequest($request);
        $formFile->handleRequest($request);

        if ($formFilm->isSubmitted() && $formFilm->isValid()) {
            $file = $formFile->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $film = $formFilm->getData();
            $film->setFile($file);
            $em->persist($film);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Film "' . $film->getName() . '" is edited !');
            return $this->redirectToRoute('list_of_all_films');
        }

        return $this->render('admin/edit_film_details.html.twig', [
            'film' => $film,
            'formFilm' => $formFilm->createView(),
            'formFile' => $formFile->createView()
        ]);
    }

    /**
     *
     * @Route("/delete/{id}", name="film_delete", methods={"DELETE"})
     */
    public function deleteFilm(Request $request, Film $film): Response
    {
        if ($this->isCsrfTokenValid('delete' . $film->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_of_all_films');
    }


}