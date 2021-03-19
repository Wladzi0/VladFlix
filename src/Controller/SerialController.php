<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 *
 * @IsGranted("ROLE_USER")
 */
class SerialController extends AbstractController
{


}