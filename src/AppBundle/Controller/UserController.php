<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class UserController extends FOSRestController
{

        /**
         * Gets a collection of BlogPosts
         *
         * @return array
         *
         * @ApiDoc(
         *     output="AppBundle\Entity\User",
         *     statusCodes={
         *         200 = "Returned when successful",
         *         404 = "Return when not found"
         *     }
         * )
         */
        public function getUserAction($id)
    {
        return $this->get('crv.doctrine_entity_repository.user')->createFindAllQuery()->getResult();
    }

}
