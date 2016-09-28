<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Cours;
use AppBundle\Repository\CoursRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursController extends FOSRestController
{
    /**
     * @Route("/cours", name="homepage")
     */

    public function indexAction()
    {


    }
}
