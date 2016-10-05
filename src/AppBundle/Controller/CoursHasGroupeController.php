<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\CoursHasGroupe;
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
 * Class CoursController
 * @package AppBundle\Controller
 */

class CoursHasGroupeController extends FOSRestController
{

    /** Find Groupes of a Cours
     * @param integer $id
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method("GET")
     * @Get("/cours/{id}/groupes/all")
     */

    public function getGroupesAction($id)
    {

        $groupe = $this->getDoctrine()->getRepository('AppBundle:CoursHasGroupe')->findGroupeByCours($id)->getResult();

        $temp = $this->get('serializer')->serialize($groupe, 'json');
        return new Response($temp);

    }

    /** Find Cours of a Groupe
     * @param integer $id
     * @return mixed
     *
     * @Method("GET")
     * @Get("/groupe/{id}/cours/all")
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     */

    public function getCoursAction($id)
    {
        $cours = $this->getDoctrine()->getRepository('AppBundle:CoursHasGroupe')->findCoursByGroupe($id)->getResult();

        $temp = $this->get('serializer')->serialize($cours, 'json');
        return new Response($temp);
    }

    /** Add Groupe to a Cours
     * @param integer $id
     * @param Request $request
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
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
     * @Post("/cours/{id}/groupe/add")
     */

    public function addGroupeToCoursAction($id,Request $request){
        $data=$request->request->all();
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->find($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($data as $d) {
            $newGroupe= $this->getDoctrine()->getRepository('AppBundle:Groupe')->find($d["id"]);
            $coursHasGroupe=new CoursHasGroupe();
            $coursHasGroupe->setGroupe($newGroupe);
            $coursHasGroupe->setCours($cours);
            $em->persist($coursHasGroupe);
        }

        $em->flush();

        return new Response('new Groupe assigned to Cours with id '.$id);
    }
}