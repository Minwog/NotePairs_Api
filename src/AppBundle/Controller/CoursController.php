<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Cours;
use AppBundle\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CoursController
 * @package AppBundle\Controller
 * @RouteResource("cours")
 *
 */

class CoursController extends FOSRestController
{
    /**
     * Get all Cours
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {
        $cours = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findAll();
        $temp = $this->get('serializer')->serialize($cours, 'json');

        return new Response($temp);
    }

    /** Gets a Cours by Categorie
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
     * GET Route annotation.
     * @Get("/cours/categorie/{id}")
     */

    public function findByCategorieAction($id){
        $categorie=$this->getDoctrine()->getRepository('AppBundle:Categorie')->find($id);
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->findBy(array('categorie'=>$categorie));

        $temp = $this->get('serializer')->serialize($cours, 'json');
        return new Response($temp);

    }

    /**
     * Get one Cours by Id
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction($id)
    {
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')->find($id);
        $temp = $this->get('serializer')->serialize($cours, 'json');

        return new Response($temp);
    }

    /**
     * Get one Cours by Name
     *
     * @param string $nom
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Get("/cours/{nom}")
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getByNameAction($nom)
    {
        $cours=$this->getDoctrine()->getRepository('AppBundle:Cours')
            ->findBy(array('nom'=>$nom));

        $temp = $this->get('serializer')->serialize($cours, 'json');


        return new Response($temp);
    }

    /** Créer un cours
     *
     * @param Request $request
     * @return mixed
     * @Method("POST")
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Cours",
     *     statusCodes={
     *     200= "Returned when successful",
     *     404= "Returned when not found"
     *     }
     *     )
     */

    public function postAction(Request $request){
        $data=$request->request->all();

        $cours=new Cours();

        if(isset($data["categorie_id"])){
            $categorie = $this->getDoctrine()->getRepository('AppBundle:Categorie')->find($data["categorie_id"]);
            $cours->setCategorie($categorie);
        }
        if(isset($data["description"])){
            $cours->setDescription($data["description"]);
        }

        if(isset($data["nom"])){
            $cours->setNom($data["nom"]);
        }
        if(isset($data["restreint"])){
            $cours->setRestreint($data['restreint']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cours);
        $em->flush();

        return new Response($this->get('serializer')->serialize($cours, 'json'));
    }

    /** Update a Cours
     * @param Request $request
     * @param integer $id
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
     * @Method({"GET","PUT"})
     */

    public function putAction(Request $request){
        $data=$request->request->all();

        $cours = $this->getDoctrine()->getRepository('AppBundle:Cours')
            ->find($data["id"]);

        if(isset($data['nom'])){
            $cours->setNom($data['nom']);
        }

        if(isset($data['categorie'])) {
            $categorie = $this->getDoctrine()->getRepository('AppBundle:Categorie')->find($data['categorie']);
            $cours->setCategorie($categorie);
        }

        if(isset($data['restreint'])){
            $cours->setrestreint($data['restreint']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cours);
        $em->flush();

        return new Response($this->get('serializer')->serialize($cours, 'json'));
    }

    /** Delete a Cours
     * @param integer $id
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

    public function deleteAction($id){
        $cours = $this->getDoctrine()->getRepository('AppBundle:Cours')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($cours);
        $em->flush();

        return new Response(json_encode(array('status' => 200)));
    }


/**/
}
