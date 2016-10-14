<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Copie;
use AppBundle\Repository\UserRepository;
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
 * Class CopieController
 * @package AppBundle\Controller
 * @RouteResource("copie")
 *
 */

class CopieController extends FOSRestController
{
    /** Gets an evaluation by UserId
     * @param integer $id
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Copie",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    /**
     * GET Route annotation.
     * @Get("/copiesbyuser/{id}")
     */
    public function getCopieByUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $copie = $this->getDoctrine()
            ->getRepository('AppBundle:Copie')
            ->findBy(array('user'=>$user));

        $temp = $this->get('serializer')->serialize($copie, 'json');
        return new Response($temp);
    }
}