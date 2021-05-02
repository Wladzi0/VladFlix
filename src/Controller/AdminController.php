<?php

namespace App\Controller;


use App\Entity\Episode;
use App\Entity\Film;
use App\Entity\Season;
use App\Entity\Serial;
use App\Entity\User;
use App\Form\EpisodeType;
use App\Form\FilmType;
use App\Form\SeasonType;
use App\Form\SerialType;
use App\Form\UserEditType;
use App\Repository\FileRepository;
use App\Repository\SerialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/film/add", name="add_new_film")
     */
    public function addFilm(Request $request)
    {
        $film = new Film();
        $formFilm = $this->createForm(FilmType::class, $film);

        $formFilm->handleRequest($request);

        if ($formFilm->isSubmitted() && $formFilm->isValid()) {
            $film = $formFilm->getData();
            $audio=$formFilm['file']['audio']->getData();
            $categories = $formFilm['categories']->getData();
            if ((0 === count($categories)) || (empty($audio))) {
                if (0 === count($categories)) {
                    $message = 'You forgot to select a category';
                } else {
                    $message = 'You forgot to select a audio';

                }

                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', $message);
                return $this->render('admin/add_or_edit_film.html.twig', [
                        'formFilm' => $formFilm->createView(),
                        'filmAction' => 'Add new film',
                    ]
                );
            }
            $timeArray = sprintf("%s:%s:%s", random_int(0,2), random_int(0,59), random_int(0,59));
//            $timeArray = [
//                '00:05:55',
//                '01:04:51',
//                '03:11:11',
//                '00:59:23'
//            ];
//            $random = array_rand($timeArray);
            $randomTime = (\DateTime::createFromFormat('H:i:s', $timeArray));
            $file=$formFilm['file']->getData();
            $file->setDuration($randomTime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Film is added!');
            return $this->redirectToRoute('list_of_all_films');
        }

        return $this->render('admin/add_or_edit_film.html.twig', [
                'formFilm' => $formFilm->createView(),
                'filmAction' => 'Add new film',
            ]
        );
    }

    /**
     * @Route("/serial/add", name="add_new_serial")
     */
    public function addSerial(Request $request)
    {
        $serial = new Serial();
        $formSerial = $this->createForm(SerialType::class, $serial);

        $formSerial->handleRequest($request);


        if ($formSerial->isSubmitted() && $formSerial->isValid()) {

            $categories = $formSerial['categories']->getData();
            if (0 === count($categories)) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'You forgot to select a category');
                return $this->render('admin/adding_of_serial/add_or_edit_serial.html.twig', [
                        'edit' => false,
                        'formSerial' => $formSerial->createView()
                    ]
                );
            }
            $serial = $formSerial->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($serial);
            $em->flush();
            return $this->redirectToRoute("add_new_season",[
                'serial' => $serial->getId()
            ]);
        }

        return $this->render('admin/adding_of_serial/add_or_edit_serial.html.twig', [
                'edit' => false,
                'formSerial' => $formSerial->createView()
            ]
        );
    }

    /**
     * @Route("/season/add", name="add_new_season")
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
                ->add('success', 'Season is added to' . $seasonData->getName());
            return $this->redirectToRoute('add_new_season',[
                'serial' => $serialId,
                'episodeButton' => true,
            ]);
        }
        return $this->render('admin/adding_of_serial/add_or_edit_season.html.twig', [
            'formSeason' => $formSeason->createView(),
            'episodeButton' => $episodeButton,
            'serial' => $serialId,
            'edit' => false,
        ]);
    }

    /**
     * @Route("serial/{serial}/episode/add", name="add_new_episode_file")
     */
    public function addNewEpisode(Request $request)
    {
        $serialId = $request->get('serial');
        $episode = new Episode();
        $formEpisode = $this->createForm(EpisodeType::class, $episode, ['bySerial' => $serialId]);
        $formEpisode->handleRequest($request);
        if ($formEpisode->isSubmitted() && $formEpisode->isValid()) {
            $audio = $formEpisode['file']['audio']->getData();
            if (empty($audio)) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'You forgot to select a audio');
                return $this->render('admin/adding_of_serial/add_or_edit_episode_file.html.twig', [
                        'formEpisodeFile' => $formEpisode->createView(),
                        'serial' => $serialId,
                        'edit' => false,
                    ]
                );
            }
            $timeArray = sprintf("00:%s:%s", random_int(0,58), random_int(0,59));
//            $timeArray = [
//                '00:55:55',
//                '00:49:00',
//                '00:11:11',
//                '00:36:23'
//            ];
//            $random = array_rand($timeArray);
            $randomTime = (\DateTime::createFromFormat('H:i:s', $timeArray));
            $file=$formEpisode['file']->getData();
            $file->setDuration($randomTime);

            $em = $this->getDoctrine()->getManager();
            $episodeData = $formEpisode->getData();
            $em->persist($episodeData);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Episode "' . $episodeData->getName() . '" is added!');
            return $this->redirectToRoute('add_new_episode_file', [
                'serial' => $serialId,
                'edit' => false,
            ]);
        }
        return $this->render('admin/adding_of_serial/add_or_edit_episode_file.html.twig', [
                'formEpisodeFile' => $formEpisode->createView(),
                'serial' => $serialId,
                'edit' => false,
            ]
        );
    }

    /**
     * @Route("/films/list", name="list_of_all_films")
     */
    public function showAllFilms(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator)
    {
        $dql = 'SELECT f FROM App\Entity\Film f';
        $query = $em->createQuery($dql);
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
     * @Route("/serials/list", name="list_of_all_serials")
     */
    public function showAllSerials(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator)
    {

        $dql = 'SELECT s FROM App\Entity\Serial s';
        $query = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );
        return $this->render('admin/serial_and_film_lists/list_of_all_serials.html.twig', [
            'serials' => $pagination
        ]);
    }

    /**
     * @Route("/serial/{id}/details", name="show_serial_details")
     */
    public function showSerialDetails(Request $request, Serial $serial): Response
    {
        return $this->render('admin/show_serial_details.html.twig', [
            'serial' => $serial
        ]);
    }

    /**
     * @Route("/serial/{id}/edit/details", name="edit_serial_details")
     */
    public function editSerialDetails(Request $request, Serial $serial)
    {
        $formSerial = $this->createForm(SerialType::class, $serial);
        $formSerial->handleRequest($request);

        if ($formSerial->isSubmitted() && $formSerial->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $serial = $formSerial->getData();
            $em->persist($serial);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Serial "' . $serial->getName() . '" is edited !');
            return $this->redirectToRoute('show_serial_details', ['id' => $serial->getId()]);
        }

        return $this->render('admin/adding_of_serial/add_or_edit_serial.html.twig', [
            'edit' => true,
            'formSerial' => $formSerial->createView()
        ]);
    }

    /**
     * @Route("/serial/{serialId}/season/{id}/edit", name="edit_season")
     */
    public function editSeason(Season $season, Request $request)
    {
        $formSeason = $this->createForm(SeasonType::class, $season);
        $formSeason->handleRequest($request);
        if ($formSeason->isSubmitted() && $formSeason->isValid()) {
            $seasonData = $formSeason->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Season is edit to ' . $seasonData->getName());
            return $this->redirectToRoute('show_serial_details', ['id' => $request->get('serialId')]);
        }
        return $this->render('admin/adding_of_serial/add_or_edit_season.html.twig', [
            'formSeason' => $formSeason->createView(),
            'edit' => true,
        ]);
    }

    /**
     *
     * @Route("/season/{id}/delete", name="season_delete", methods={"DELETE"})
     */
    public function deleteSeason(Request $request, Season $season): Response
    {
        if ($this->isCsrfTokenValid('delete' . $season->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($season);
            $entityManager->flush();
        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Season is deleted!');
        return $this->redirectToRoute('list_of_all_serials');
    }

    /**
     *
     * @Route("/serial/{id}/delete", name="serial_delete", methods={"DELETE"})
     */
    public function deleteSerial(Request $request, Serial $serial): Response
    {
        if ($this->isCsrfTokenValid('delete' . $serial->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serial);
            $entityManager->flush();
        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Serial is deleted!');
        return $this->redirectToRoute('list_of_all_serials');
    }

    /**
     * @Route("/serial/{serial}/episode/{id}/edit", name="edit_episode_file")
     */
    public function editEpisode(Request $request, Episode $episode, FileRepository $fileRepository): Response
    {
        $serialId = $request->get('serial');
        $formEpisode = $this->createForm(EpisodeType::class, $episode, ['bySerial' => $serialId]);
        $formEpisode->handleRequest($request);
        if ($formEpisode->isSubmitted() && $formEpisode->isValid()) {
            $audio = $formEpisode['file']['audio']->getData();
            if (empty($audio)) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'It is not possible to delete all audio');
                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);
            }
            $em = $this->getDoctrine()->getManager();
            $episodeData = $formEpisode->getData();
            $em->persist($episodeData);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Episode "' . $episodeData->getName() . '" is edited!');
            return $this->redirectToRoute('show_serial_details', ['id' => $serialId]);
        }
        return $this->render('admin/adding_of_serial/add_or_edit_episode_file.html.twig', [
                'formEpisodeFile' => $formEpisode->createView(),
                'edit' => true,
            ]
        );
    }

    /**
     *
     * @Route("/episode/{id}/delete", name="episode_delete", methods={"DELETE"})
     */
    public function deleteEpisode(Request $request, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete' . $episode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Episode is deleted!');
        return $this->redirectToRoute('list_of_all_serials');
    }

    /**
     * @Route("/film/{id}/edit", name="edit_film_details", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editFilmDetails(FileRepository $fileRepository, Request $request, Film $film)
    {
        $formFilm = $this->createForm(FilmType::class, $film);

        $formFilm->handleRequest($request);

        if ($formFilm->isSubmitted() && $formFilm->isValid()) {
            $categories = $formFilm['categories']->getData();
            $audio = $formFilm['file']['audio']->getData();
            if ((0 === count($categories)) || (empty($audio))) {////
                if (0 === count($categories)) {////
                    $message = 'You forgot to select a category';//
                } else {
                    $message = 'It is not possible to delete all audio';///

                }
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', $message);
                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);
            }

            $em = $this->getDoctrine()->getManager();

            $film = $formFilm->getData();

            $em->persist($film);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Film "' . $film->getName() . '" is edited!');
            return $this->redirectToRoute('list_of_all_films');
        }

        return $this->render('admin/add_or_edit_film.html.twig', [
            'film' => $film,
            'filmAction' => 'Edit film',
            'formFilm' => $formFilm->createView(),
        ]);
    }


    /**
     * @Route("/user/{id}/edit", name="edit_user", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editUser(Request $request, User $user)
    {

        $formUser = $this->createForm(UserEditType::class, $user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            if ($userFName = $formUser['firstName']->getData()) {
                $user->setFirstName($userFName);
            }
            if ($userLName = $formUser['lastName']->getData()) {
                $user->setLastName($userLName);
            }
            if ($userEmail = $formUser['email']->getData()) {
                $user->setEmail($userEmail);
            }
            if ($userLanguage = $formUser['defaultLanguage']->getData()) {
                $user->setDefaultLanguage($userLanguage);
            }
            if (
            $userPin = $formUser['pin']->getData()) {
                $user->setPin($userPin);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'User is edited!');
            return $this->redirectToRoute('users');
        }

        return $this->render('admin/editUser.html.twig', [
            'userForm' => $formUser->createView(),
            'edit' => true,
        ]);
    }

    /**
     *
     * @Route("/film/{id}/delete", name="film_delete", methods={"DELETE"})
     */
    public function deleteFilm(Request $request, Film $film): Response
    {
        if ($this->isCsrfTokenValid('delete' . $film->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($film);
            $entityManager->flush();
        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Film is deleted!');
        return $this->redirectToRoute('list_of_all_films');
    }

    /**
     * @Route ("/users/list", name="users")
     */
    public function listOfUsers(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $dql = 'SELECT u FROM App\Entity\User u';
        $query = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2));

        return $this->render('admin/list_of_users.html.twig', [
            'users' => $pagination]);
    }

    /**
     *
     * @Route("/user/{id}/delete", name="user_delete", methods={"DELETE"})
     */
    public function userDelete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'User is deleted!');
        return $this->redirectToRoute('users');
    }

}