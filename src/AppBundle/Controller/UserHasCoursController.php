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
use FOS\RestBundle\Controller\Annotations\Delete;
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

    public function getCoursbyUserAction($id)
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

    public function getUserByCoursAction($id)
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

    /** Add Cours to a user
     * @param integer $coursid
     * @param integer $userid
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
     * @Method("DELETE")
     *
     */
    /**
     * DELETE Route annotation.
     * @Delete("/cours/{coursid}/users/{userid}")
     */

    public function deleteUserfromCoursAction($coursid,$userid){
        $user=$this->getDoctrine()->getRepository('AppBundle:User')->find($userid);
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->find($coursid);
        if($user==null || $cours==null){
            return new Response(json_encode(array('status'=>404)));
        }
        $userHasCours=$this->getDoctrine()->getRepository('AppBundle:UserHasCours')->findOneBy(array('user'=>$user,'cours'=>$cours));
        $em = $this->getDoctrine()->getManager();
        $em->remove($userHasCours);
        $em->flush();
        return new Response(json_encode(array('status'=>200)));
    }


    /** Add User to Cours
     * @param integer $id
     * @param Request $request
     *
     *request : tableau d'ids d'user a ajouter au cours.
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
     * @Post("/cours/{id}/users/add")
     */

    public function addUserToCoursAction($id,Request $request){
        $data=$request->request->all();
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->find($id);
        $em = $this->getDoctrine()->getManager();
        $fail=0;
        foreach ($data as $d) {
            $newUser= $this->getDoctrine()->getRepository('AppBundle:User')->find($d);
            if($newUser==null){
                $fail++;
            }
            $userHasCours=new UserHasCours();
            $userHasCours->setUser($newUser);
            $userHasCours->setCours($cours);
            $em->persist($userHasCours);
        }

        if($fail>0){
            return new Response(json_encode(array('status'=>1,'fail'=>$fail)));
        }
        $em->flush();

        return new Response(json_encode(array('status'=>200,)));
    }
}