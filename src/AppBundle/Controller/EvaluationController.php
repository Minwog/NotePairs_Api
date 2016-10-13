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
use AppBundle\Entity\Critere;
use AppBundle\Entity\Parametre;
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
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Date;


/**
 * Class EvaluationController
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

    /** Gets an evaluation by CoursId
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
    /**
     * GET Route annotation.
     * @Get("/evaluationsbycours/{id}")
     */
    public function getByCoursAction($id)
    {
        $cours = $this->getDoctrine()->getRepository('AppBundle:Cours')->find($id);
        $evaluation = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->findBy(array('cours'=>$cours));

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
     * @Method("POST")
     *
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
        /*$evaluation->setDateRendu('date_rendu', DateType::class, array(
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'd/m/Y',
        ));
        $evaluation->setDateRendu('date_fin_correction', DateType::class, array(
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
        ));
            /*Date::createFromFormat('d/m/Y', $data['date_rendu']));
        $evaluation->setDateFinCorrection(Date::createFromFormat('d/m/Y', $data['date_fin_correction']));*/
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

        return new Response(json_encode(array('id'=>$evaluation->getId())));


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
     * @Method({"GET","PUT"})
     *
     */

    public function putAction(Request $request){
        $data=$request->request->all();

        $evaluation = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($data['id']);

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

    /** Delete une evaluation
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
     */

    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();

        $evaluation = $this->getDoctrine()->getRepository('AppBundle:Evaluation')->find($id);

        if ($evaluation === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em->remove($evaluation);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }


    /** Find les sections de l'evaluation
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

    /** Find une section de l'evaluation
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
     * @Get("/section/{id}")
     */

    public function getSectionAction($id){

        $section = $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($id);

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

    public function postSectionAction(Request $request, $id){

        $evaluation= $this->getDoctrine()
            ->getRepository('AppBundle:Evaluation')
            ->find($id);

        $data=$request->request->all();

        if(isset($data['type_rendu'])) {
            $parametre = $this->getDoctrine()
                ->getRepository('AppBundle:Parametre')
                ->find($data['type_rendu']);
        } else {
            $parametre = $this->getDoctrine()
                ->getRepository('AppBundle:Parametre')
                ->find(1);
        }

        $section=new Section();

        $section->setEvaluation($evaluation);
        if(isset($data['titre'])) {
            $section->setTitre($data['titre']);
        }else {
            $section->setTitre('');
        }
        if(isset($data['enonce'])) {
            $section->setEnonce($data['enonce']);
        }else {
            $section->setEnonce('');
        }
        if(isset($data['description'])) {
            $section->setDescription($data['description']);
        }else {
            $section->setDescription('');
        }

        $section->setTypeRendu($parametre);

        $em = $this->getDoctrine()->getManager();
        $em->persist($section);
        $em->flush();

        if(isset($data['ordre'])) {
            $section->setOrdre($data['ordre']);
        }else {
            $section->setOrdre($section->getId());
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($section);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $section->getId().'}');

    }

    /** Get all type rendu
     *
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
     * @Get("/type_rendu")
     */

    public function cgetTypeRenduAction(){

        $typeRendu = $this->getDoctrine()
            ->getRepository('AppBundle:Parametre')
            ->findBy(array(), array());

        $temp = $this->get('serializer')->serialize($typeRendu, 'json');
        return new Response($temp);

    }

    /** Get type rendu (pour une section)
     * @param integer $e
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
     * @Get("/type_rendu/{e}")
     */

    public function getTypeRenduAction($e){

        $typeRendu = $this->getDoctrine()
            ->getRepository('AppBundle:Parametre')
            ->findBy(array('extension'=>$e));

        $temp = $this->get('serializer')->serialize($typeRendu, 'json');
        return new Response($temp);

    }

    /** Create type rendu (pour une section)
     * @param integer $e
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

    /**
     *POST Route annotation.
     * @Post("/type_rendu/{e}")
     */

    public function createTypeRenduAction($e){

        $typeRendu=new Parametre();
        $typeRendu->setExtension($e);

        $em = $this->getDoctrine()->getManager();
        $em->persist($typeRendu);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $typeRendu->getId().'}');

    }


    /** Update sections
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
     * @Method({"GET","PUT"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/evaluations/section/{id}")
     */

    /**
     *PUT Route annotation.
     * @Put("/sections/{id}")
     */

    public function updateSectionAction(Request $request, $id){

        $data=$request->request->all();

        $section= $this->getDoctrine()
            ->getRepository('AppBundle:Section')
            ->find($id);

        if(isset($data['type_rendu'])) {
            $parametre = $this->getDoctrine()
                ->getRepository('AppBundle:Parametre')
                ->find($data['type_rendu']);
            $section->setTypeRendu($parametre);
        }

        if(isset($data['titre'])) {
            $section->setTitre($data['titre']);
        }

        if(isset($data['enonce'])) {
            $section->setEnonce($data['enonce']);
        }

        if(isset($data['description'])) {
            $section->setDescription($data['description']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($section);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $section->getId().'}');

    }

    /** Update ordre de la section
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
     * @Method({"GET","PUT"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/sections/{id}/update_ordre")
     */

    /**
     *PUT Route annotation.
     * @Put("/sections/{id}/update_ordre/{ordre}")
     */

    public function updateOrdreSectionAction($id, $ordre){

        $section= $this->getDoctrine()
            ->getRepository('AppBundle:Section')
            ->find($id);

        $section->setOrdre($ordre);

        $em = $this->getDoctrine()->getManager();
        $em->persist($section);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $section->getId().'}');

    }

    /** Delete une section
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
     * @Method({"DELETE"})
     *
     */

    /**
     *DELETE Route annotation.
     * @Delete("/sections/{id}")
     */

    public function deleteSectionAction($id){

        $em = $this->getDoctrine()->getManager();

        $section = $this->getDoctrine()->getRepository('AppBundle:Section')->find($id);

        if ($section === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em->remove($section);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }


    /** Find les critères de la section
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
     * @Get("/sections/{id}/criteres")
     */

    public function getCriteresAction($id){

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('c')
            ->from('AppBundle:Critere','c')
            ->where('c.section ='.$id)
            ->orderBy('c.ordre', 'ASC');

        $critere=$qb->getQuery()->getResult();

        $temp = $this->get('serializer')->serialize($critere, 'json');
        return new Response($temp);

    }

    /** Find un critere de la section
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
     * @Get("/criteres/{id}")
     */

    public function getCritereAction($id){

        $critere = $this->getDoctrine()
            ->getRepository('AppBundle:Critere')
            ->find($id);

        $temp = $this->get('serializer')->serialize($critere, 'json');
        return new Response($temp);

    }

    /** Add critères à la section
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

    /**
     *POST Route annotation.
     * @Post("/sections/{id}/criteres")
     */

    public function postCritereAction(Request $request,$id){

        $data=$request->request->all();

        $section= $this->getDoctrine()
            ->getRepository('AppBundle:Section')
            ->find($id);

        if(isset($data['type'])) {
            $type = $this->getDoctrine()
                ->getRepository('AppBundle:TypeCritere')
                ->find($data['type']);
        } else {
            $type = $this->getDoctrine()
                ->getRepository('AppBundle:TypeCritere')
                ->find(1);
        }

        $critere=new Critere();

        $critere->setSection($section);

        if(isset($data['description'])) {
            $critere->setDescription($data['description']);
        }else {
            $critere->setDescription('');
        }

        if(isset($data['points_max'])) {
            $critere->setPointsMax($data['points_max']);
        }else {
            $critere->setPointsMax(1);
        }

        $critere->setType($type);

        $em = $this->getDoctrine()->getManager();
        $em->persist($critere);
        $em->flush();

        $critere->setOrdre($id);

        $em = $this->getDoctrine()->getManager();
        $em->persist($critere);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $critere->getId().'}');

    }

    /** Add critères à la section
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
     * @Method({"GET","PUT"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/criteres.{id}")
     */

    /**
     *PUT Route annotation.
     * @Put("criteres/{id}")
     */

    public function updateCritereAction(Request $request,$id){

        $data=$request->request->all();

        $critere= $this->getDoctrine()
            ->getRepository('AppBundle:Critere')
            ->find($id);

        if(isset($data['type'])) {
            $type = $this->getDoctrine()
                ->getRepository('AppBundle:TypeCritere')
                ->find($data['type']);
                $critere->setType($type);
        }

        if(isset($data['description'])) {
            $critere->setDescription($data['description']);
        }

        if(isset($data['points_max'])) {
            $critere->setPointsMax($data['points_max']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($critere);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $critere->getId().'}');

    }

    /** Update ordre de la section
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
     * @Method({"GET","PUT"})
     *
     */

    /**
     *GET Route annotation.
     * @Get("/criteres/{id}/update_ordre")
     */

    /**
     *PUT Route annotation.
     * @Put("/criteres/{id}/update_ordre({ordre})")
     */

    public function updateOrdreCritereAction($id, $ordre){

        $critere= $this->getDoctrine()
            ->getRepository('AppBundle:Critere')
            ->find($id);

        $critere->setOrdre($ordre);

        $em = $this->getDoctrine()->getManager();
        $em->persist($critere);
        $em->flush();

        return new Response('{status:'. 200 .',id:'. $critere->getId().'}');

    }

    /** Delete un critère
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
     * @Method({"DELETE"})
     *
     */

    /**
     *DELETE Route annotation.
     * @Delete("/criteres/{id}")
     */

    public function deleteCritereAction($id){

        $em = $this->getDoctrine()->getManager();

        $critere = $this->getDoctrine()->getRepository('AppBundle:Critere')->find($id);

        if ($critere === null) {
            return new Response('HTTP_NOT_FOUND');
        }

        $em->remove($critere);
        $em->flush();

        return new Response('HTTP_NO_CONTENT');
    }

}


