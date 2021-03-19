<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use App\Repository\SerialRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 *
 * @IsGranted("ROLE_USER")
 */
class FilmController extends AbstractController
{



}