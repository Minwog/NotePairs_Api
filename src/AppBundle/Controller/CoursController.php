<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CoursController
 * @package AppBundle\Controller
 * @RouteResource("cours")
 *
 */

class CoursController extends FOSRestController
{
    /**
     *
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {
        $cours = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findAll();
        $temp = $this->get('serializer')->serialize($cours, 'json');

        return new Response($temp);
    }


}
