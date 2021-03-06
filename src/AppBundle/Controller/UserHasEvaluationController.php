<?php
/**
 * Created by PhpStorm.
 * User: aurore
 * Date: 05/10/2016
 * Time: 11:21
 */

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Evaluation;
use AppBundle\Entity\Section;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHasEvaluation;
use AppBundle\Repository\EvaluationRepository;
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
 * Class UserHasEvaluationController
 * @package AppBundle\Controller
 *  @RouteResource("userHasEvaluation")
 */

class UserHasEvaluationController extends FOSRestController
{

    /** Find Evaluations by User
     * @param integer $id
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method({"GET"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/user/{id}/evaluations")
     * @param $id
     * @return Response
     */

    public function getMesEvaluationsAction($id)
    {
        $evaluation = $this->getDoctrine()->getRepository('AppBundle:UserHasEvaluation')->findUserHasEvaluationByUser($id)->getResult();

        $temp = $this->get('serializer')->serialize($evaluation, 'json');
        return new Response($temp);
    }


    /** Find devoir à rendre$
     * @param integer $id
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method({"GET"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/user/{id}/devoirs_a_rendre")
     */

    public function getDevoirsARendreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $today = \Date("now");

        $qb->select('e')
            ->from('AppBundle:Evaluation', 'e')
            ->where('e.dateRendu <=' . $today)
            ->orderBy('e.dateRendu', 'ASC');

        $evaluations = $qb->getQuery()->getResult();

        $temp = $this->get('serializer')->serialize($evaluations, 'json');

        return new Response($temp);
    }

    /** Add evaluation to user
     * @param integer $id
     * @param Request $request
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method({"POST","GET"})
     *
     */

    /**
     *POST Route annotation.
     * @Post("/evaluation/{id}/add_users")
     */

    public function addUserToEvaluationAction(Request $request, $id)
    {
        $data=$request->request->all();
        $evaluation=$this->getDoctrine()->getRepository('AppBundle:Evaluation')->find($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($data as $d) {
            $newUser= $this->getDoctrine()->getRepository('AppBundle:User')->find($d["id"]);
            $userHasEvaluation=new UserHasEvaluation();
            $userHasEvaluation->setUser($newUser);
            $userHasEvaluation->setEvaluation($evaluation);
            $em->persist($userHasEvaluation);
        }

        $em->flush();

        return new Response('new users assigned to evaluation with id '.$id);
    }

    /** Add evaluation to user
     * @param integer $id_eval
     * @param integer $id_user
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method({"DELETE"})
     *
     */

    /**
     *DELETE Route annotation.
     * @Delete("/evaluation/{id_eval}/delete_user/{id_user}")
     */

    public function deleteUserFromEvaluationAction($id_eval, $id_user)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id_user);

        $eval = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($id_eval);

        $userHasEval = $this->getDoctrine()
            ->getRepository('AppBundle:UserHasEvaluation')
            ->findBy(array('user' => $user, 'evaluation' => $eval));

        if ($userHasEval === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em->remove($userHasEval[0]);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }

    /** Check number of evaluations for each user
     * @param integer $id_eval
     * @param integer $id_user
     *
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     *
     * @Method({"DELETE"})
     *
     */

    /**
     *DELETE Route annotation.
     * @Delete("/evaluation/{id_eval}/delete_user/{id_user}")
     */



}