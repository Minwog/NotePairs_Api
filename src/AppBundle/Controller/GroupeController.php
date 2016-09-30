<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class GroupeController
 * @package AppBundle\Controller
 * @RouteResource("groupe")
 *
 */

class GroupeController extends FOSRestController
{
    /**
     *
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Groupe",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {
        $groupe = $this->getDoctrine()
            ->getRepository('AppBundle:Groupe')
            ->findAll();
        $temp = $this->get('serializer')->serialize($groupe, 'json');

        return new Response($temp);
    }


}