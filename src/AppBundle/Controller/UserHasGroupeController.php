<?php
namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHasGroupe;
use AppBundle\Entity\Groupe;
use AppBundle\Repository\UserRepository;
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
* Class UserHasGroupeController
* @package AppBundle\Controller
*/

class UserHasGroupeController extends FOSRestController
{

    /** Find Groupes of a user
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
     * @Get("/users/{id}/groupe/all")
     */

    public function getGroupeAction($id)
    {

        $groupe = $this->getDoctrine()->getRepository('AppBundle:UserHasGroupe')->findUserHasGroupeByUser($id)->getResult();

        $temp = $this->get('serializer')->serialize($groupe, 'json');
        return new Response($temp);

    }


    /** Add Existing Groupe to existing user
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
     * @Post("/users/{id}/groupe/add")
     */

    public function addGroupeToUserAction($id, Request $request)
    {
        $data = $request->request->all();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($data as $d) {
            $newGroupe = $this->getDoctrine()->getRepository('AppBundle:Groupe')->find($d["id"]);
            $userHasGroupe= new UserHasGroupe();
            $userHasGroupe->setGroupe($newGroupe);
            $userHasGroupe->setUser($user);
            $em->persist($userHasGroupe);
        }

        $em->flush();

        return new Response('new Cours assigned to user with id ' . $id);
    }
}