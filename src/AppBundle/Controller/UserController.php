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
 * Class UserController
 * @package AppBundle\Controller
 *  @RouteResource("user")
 */


class UserController extends FOSRestController
{

    /**
     * Gets a collection of users
     *
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\User",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {

        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        $temp = $this->get('serializer')->serialize($users, 'json');

       return new Response($temp);


    }

    /**
     * Gets a user
     *
     * @param integer $id
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\User",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */

    public function getAction($id)
    {
        $user=$this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        $temp=$this->get('serializer')->serialize($user,'json');
        return new Response($temp);
    }



}
