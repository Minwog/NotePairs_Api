<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHasCours;
use AppBundle\Entity\Cours;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\RoleRepository;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class UserHasCoursController
 * @package AppBundle\Controller
 */

class UserHasCoursController extends FOSRestController
{

    /** Find Cours of a user
     * @param integer $id
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\User",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method("GET")
     *
     */
    /**
     * GET Route annotation.
     * @Get("/users/{id}/cours/all")
     */

    public function getCoursAction($id)
    {

        $cours = $this->getDoctrine()->getRepository('AppBundle:UserHasCours')->findCoursByUser($id)->getResult();

        $temp = $this->get('serializer')->serialize($cours, 'json');
        return new Response($temp);

    }

    /** Find User of a Cours
     * @param integer $id
     * @return mixed
     *
     * @Method("GET")
     * @Get("/cours/{id}/users/all")
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\User",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     */

    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:UserHasCours')->findUserByCours($id)->getResult();

        $temp = $this->get('serializer')->serialize($user, 'json');
        return new Response($temp);
    }

    /** Add Cours to a user
     * @param integer $id
     * @param Request $request
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\User",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method("POST")
     *
     */
    /**
     * POST Route annotation.
     * @Post("/users/{id}/cours/add")
     */

    public function addCoursToUserAction($id,Request $request){
        $data=$request->request->all();
        $user=$this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($data as $d) {
            $newCours= $this->getDoctrine()->getRepository('AppBundle:Cours')->find($d["id"]);
            $userHasCours=new UserHasCours();
            $userHasCours->setCours($newCours);
            $userHasCours->setUser($user);
            $em->persist($userHasCours);
        }

       $em->flush();

        return new Response('new Cours assigned to user with id '.$id);
    }
}