<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHasCours;
use AppBundle\Entity\Role;
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
            ->findBy(array(), array('role' => 'ASC'));

        $temp = $this->get('serializer')->serialize($users, 'json');

        return new Response($temp);


    }

    /**
     * Gets a user by Id
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
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        $temp = $this->get('serializer')->serialize($user, 'json');
        return new Response($temp);
    }

    /** Gets a user by Name Surname
 * @param string $surname
 * @param string $firstname
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
 */

    /**
     * GET Route annotation.
     * @Get("/users/{surname}/{firstname}")
     */

    public function getByNameAction($surname, $firstname)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findBy(array('nom' => $surname, 'prenom' => $firstname));

        $temp = $this->get('serializer')->serialize($user, 'json');

        return new Response($temp);
    }

    /** Gets a users by RoleId
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
     */

    /**
     * GET Route annotation.
     * @Get("/userbyrole/{id}")
     */

    public function getRoleAction($id){
        $role = $this->getDoctrine()
            ->getRepository('AppBundle:Role')
            ->find($id);
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findBy(array('role' => $role));

        $temp = $this->get('serializer')->serialize($user, 'json');
        return new Response($temp);

    }


    /** Create a user
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
     * @Method("POST"})
     *
     */

    /**
     * POST Route annotation.
     * @Post("/users/add")
     */

    public function postAction(Request $request){
        $data=$request->request->all();
        $user = new User();

        if(isset($data['role_id'])) {

            $role = $this->getDoctrine()->getRepository('AppBundle:Role')->find($data['role_id']);
            $user->setRole($role);
        }

        if(isset($data["nom"])){
            $user->setNom($data['nom']);
        }
        if(isset($data["prenom"])){
            $user->setPrenom($data['prenom']);
        }
        if(isset($data["email"])){
            $user->setEmail($data['email']);
        }
        if(isset($data["username"])){
            $user->setUsername($data['username']);
        }
        if(isset($data["image"])){
            $user->setImage($data['image']);
        }
        $user->setFiabilite(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $user->getId().'}');


    }


    /** Delete a user
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
     *
     */

    public function deleteAction($id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        if ($user === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }


    /** Update general information of a user
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
     */

    public function updateAction($id,Request $request){

        $data=$request->request->all();

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($user === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        if(isset($data["nom"])){
            $user->setNom($data['nom']);
        }
        if(isset($data["prenom"])){
            $user->setPrenom($data['prenom']);
        }
        if(isset($data["email"])){
            $user->setEmail($data['email']);
        }
        if(isset($data["username"])){
            $user->setUsername($data['username']);
        }
        if(isset($data["image"])){
            $user->setImage($data['image']);
        }
        if(isset($data["moyenne"])){
            $user->setMoyenne($data['moyenne']);
        }
        if(isset($data["fiabilite"])){
            $user->setFiabilite($data['fiabilite']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $user->getId().'}');

    }

    /** Update fiabilite of a user
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
     * /**
     * POST Route annotation.
     * @Post("/users/{id}/fiabilite")
     */



    public function updateFiabiliteAction($id, Request $request){
        $data=$request->request->all();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $user->setFiabilite($data['fiabilite']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('fiabilite updated for user '.$id);

    }






}

