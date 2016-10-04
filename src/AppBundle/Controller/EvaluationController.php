<?php
/**
 * Created by PhpStorm.
 * User: aurore
 * Date: 04/10/2016
 * Time: 14:24
 */

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Evaluation;
use AppBundle\Entity\Section;
/*use AppBundle\Entity\ModeCalcul;
use AppBundle\Entity\User;
use AppBundle\Entity\Cours;
use AppBundle\Entity\Categorie;*/
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Date;


/**
 * Class UserController
 * @package AppBundle\Controller
 *  @RouteResource("evaluation")
 */


class EvaluationController extends FOSRestController
{

    /**
     * Gets a collection of evaluations
     *
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {

        $evaluations = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->findBy(array(), array('dateRendu' => 'ASC'));

        $temp = $this->get('serializer')->serialize($evaluations, 'json');

        return new Response($temp);


    }

    /**
     * Gets an evaluation by Id
     *
     * @param integer $id
     * @return mixed
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Evaluation",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */

    public function getAction($id)
    {
        $evaluation = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($id);

        $temp = $this->get('serializer')->serialize($evaluation, 'json');
        return new Response($temp);
    }

    /** Create an evaluation
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
     * @Method("POST"})
     *
     */

    /**
     * POST Route annotation.
     * @Post("/evaluations/add")
     */

    public function postAction(Request $request){
        $data=$request->request->all();

        $evaluation=new Evaluation();
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->find($data['cours_id']);
        $enseignant=$this->getDoctrine()->getRepository('AppBundle:User')->find($data['enseignant_id']);

        if(isset($data['mode_calcul'])) {
            $modeCalcul = $this->getDoctrine()->getRepository('AppBundle:ModeCalcul')->find($data['mode_calcul']);
        } else {
            $modeCalcul = $this->getDoctrine()->getRepository('AppBundle:ModeCalcul')->find(1);
        }

        $evaluation->setEnseignant($enseignant);
        $evaluation->setCours($cours);
        $evaluation->setModeCalcul($modeCalcul);
        $evaluation->setNom($data['nom']);
        $evaluation->setDateRendu(DateTime::createFromFormat('d/m/Y', $data['date_rendu']));
        $evaluation->setDateFinCorrection(DateTime::createFromFormat('d/m/Y', $data['date_fin_correction']));
        $evaluation->setNombreEval($data['nombreEval']);
        if(isset($data['anonymat'])){
            $evaluation->setAnonymat($data['anonymat']);
        }
        else {
            $evaluation->setAnonymat(0);
        };

        if(isset($data['isCalibration'])){
            $evaluation->setIsCalibration($data['isCalibration']);
        } else {
            $evaluation->setIsCalibration(0);
        };

        if(isset($data['isCalculBiais'])){
            $evaluation->setIsCalculBiais($data['isCalculBiais']);
        } else {
            $evaluation->setIsCalculBiais(0);
        };

        if(isset($data['autoevaluation'])){
            $evaluation->setAutoevaluation($data['autoevaluation']);
        } else {
            $evaluation->setAutoevaluation('non');
        };

        if(isset($data['mode_eval'])){
            $evaluation->setModeEval($data['mode_eval']);
        } else {
            $evaluation->setModeEval('');
        };

        if(isset($data['mode_attribution'])){
            $evaluation->setModeAttribution($data['mode_attribution']);
        } else {
            $evaluation->setModeAttribution('supervise');
        };

        if(isset($data['travail_individuel'])){
            $evaluation->setTravailIndividuel($data['travail_individuel']);
        } else {
            $evaluation->setTravailIndividuel(1);
        };

        if(isset($data['correction_individuelle'])){
            $evaluation->setCorrectionIndividuelle($data['correction_individuelle']);
        } else {
            $evaluation->setCorrectionIndividuelle(1);
        };

        $em = $this->getDoctrine()->getManager();
        $em->persist($evaluation);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $evaluation->getId().'}');


    }


    /** Update an evaluation
     * @param Request $request
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
     * @Method({"GET,"POST"})
     *
     */

    /**
     * POST Route annotation.
     * @Post("/evaluations/update/{id}")
     */

    public function updateAction(Request $request, $id){
        $data=$request->request->all();

        $evaluation = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($id);

        if(isset($data['mode_calcul'])) {
            $modeCalcul = $this->getDoctrine()->getRepository('AppBundle:ModeCalcul')->find($data['mode_calcul']);
            $evaluation->setModeCalcul($modeCalcul);
        }

        if(isset($data['nom'])){
            $evaluation->setNom($data['nom']);
        }

        if(isset($data['date_rendu'])) {
            $evaluation->setDateRendu(DateTime::createFromFormat('d/m/Y', $data['date_rendu']));
        }

        if(isset($data['date_fin_correction'])) {
            $evaluation->setDateFinCorrection(DateTime::createFromFormat('d/m/Y', $data['date_fin_correction']));
        }

        if(isset($data['nombreEval'])){
            $evaluation->setNombreEval($data['nombreEval']);
        }

        if(isset($data['anonymat'])){
            $evaluation->setAnonymat($data['anonymat']);
        };

        if(isset($data['isCalibration'])){
            $evaluation->setIsCalibration($data['isCalibration']);
        };

        if(isset($data['isCalculBiais'])){
            $evaluation->setIsCalculBiais($data['isCalculBiais']);
        };

        if(isset($data['autoevaluation'])){
            $evaluation->setAutoevaluation($data['autoevaluation']);
        };

        if(isset($data['mode_eval'])){
            $evaluation->setModeEval($data['mode_eval']);
        };

        if(isset($data['mode_attribution'])){
            $evaluation->setModeAttribution($data['mode_attribution']);
        };

        $em = $this->getDoctrine()->getManager();
        $em->persist($evaluation);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $evaluation->getId().'}');

    }

    /** Find devoir à rendre
     * @param Request $request
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
     * @Get("/devoirs_a_rendre")
     */

    public function getDevoirsARendreAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $today= \Date("now");

        $qb->select('e')
            ->from('AppBundle:Evaluation', 'e')
            ->where('e.dateRendu <='.$today)
            ->orderBy('e.dateRendu', 'ASC');

        $evaluations=$qb->getQuery()->getResult();

        $temp = $this->get('serializer')->serialize($evaluations, 'json');

        return new Response($temp);
    }

    /** Find evaluations en cours
     * @param Request $request
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
     * @Get("/evaluations_en_cours")
     */

    public function getEvaluationsAFaireAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $today= \Date("now");

        $qb->select('e')
            ->from('AppBundle:Evaluation', 'e')
            ->where('e.dateRendu>='.$today.' AND e.dateFinCorrection <='.$today)
            ->orderBy('e.dateFinCorrection', 'ASC');

        $evaluations=$qb->getQuery()->getResult();

        $temp = $this->get('serializer')->serialize($evaluations, 'json');

        return new Response($temp);

    }

    /** Find les sections de l'evaluation
     * @param Request $request
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

    public function getSectionsAction($id){

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('s')
            ->from('AppBundle:Section','s')
            ->where('s.evaluation ='.$id)
            ->orderBy('s.ordre', 'ASC');

        $section=$qb->getQuery()->getResult();

        $temp = $this->get('serializer')->serialize($section, 'json');
        return new Response($temp);

    }

    /** Add sections a l'evaluation
     * @param Request $request
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
     * @Method({"POST"})
     *
     */

    public function addSectionsAction(Request $request,$id){



    }

}


