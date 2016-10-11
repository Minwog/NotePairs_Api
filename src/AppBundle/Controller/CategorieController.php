<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Categorie;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CoursController
 * @package AppBundle\Controller
 * @RouteResource("categorie")
 *
 */

class CategorieController extends FOSRestController
{
    /**
     * Get all Categories
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Categorie",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {
        $categorie= $this->getDoctrine()
            ->getRepository('AppBundle:Categorie')
            ->findAll();
        $temp = $this->get('serializer')->serialize($categorie, 'json');

        return new Response($temp);
    }

}