<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserHasGroupe;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Groupe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;

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

    /**
     * Gets a groupe by Id
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
        $groupe = $this->getDoctrine()
            ->getRepository('AppBundle:Groupe')
            ->find($id);

        $temp = $this->get('serializer')->serialize($groupe, 'json');
        return new Response($temp);
    }

    /** Create a groupe
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

    public function postAction(Request $request){
        $data=$request->request->all();
        $groupe = new Groupe();

        if(isset($data["nom"])){
            $groupe->setNom($data['nom']);
        }

        if(isset($data["eleves"])){
            foreach ($data["eleves"] as $eleve) {
                $neweleve=$this->getDoctrine()->getRepository('AppBundle:User')->find($eleve["id"]);
                $eleveHasGroupe=new UserHasGroupe();
                $eleveHasGroupe->setUser($neweleve);
                $eleveHasGroupe->setGroupe($groupe);
            };
        }



        $em = $this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $groupe->getId().'}');


    }


    /** Delete a groupe
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
        $groupe = $this->getDoctrine()->getRepository('AppBundle:Groupe')->find($id);

        if ($groupe === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($groupe);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }


    /** Update general information of a groupe
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

        $groupe = $this->getDoctrine()->getRepository('AppBundle:Groupe')->find($id);
        if ($groupe === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        if(isset($data["nom"])){
            $groupe->setNom($data['nom']);
        }
        if(isset($data["moyenne"])){
            $groupe->setMoyenne($data['moyenne']);
        }
        if(isset($data["fiabilite"])){
            $groupe->setFiabilite($data['fiabilite']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $groupe->getId().'}');

    }



}