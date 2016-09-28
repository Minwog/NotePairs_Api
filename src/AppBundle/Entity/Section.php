<?php

namespace AppBundle\Entity;

/**
 * Section
 */
class Section
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $enonce;

    /**
     * @var integer
     */
    private $ordre;

    /**
     * @var \AppBundle\Entity\Parametre
     */
    private $typeRendu;

    /**
     * @var \AppBundle\Entity\Evaluation
     */
    private $evaluation;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Section
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Section
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enonce
     *
     * @param string $enonce
     *
     * @return Section
     */
    public function setEnonce($enonce)
    {
        $this->enonce = $enonce;

        return $this;
    }

    /**
     * Get enonce
     *
     * @return string
     */
    public function getEnonce()
    {
        return $this->enonce;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Section
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set typeRendu
     *
     * @param \AppBundle\Entity\Parametre $typeRendu
     *
     * @return Section
     */
    public function setTypeRendu(\AppBundle\Entity\Parametre $typeRendu = null)
    {
        $this->typeRendu = $typeRendu;

        return $this;
    }

    /**
     * Get typeRendu
     *
     * @return \AppBundle\Entity\Parametre
     */
    public function getTypeRendu()
    {
        return $this->typeRendu;
    }

    /**
     * Set evaluation
     *
     * @param \AppBundle\Entity\Evaluation $evaluation
     *
     * @return Section
     */
    public function setEvaluation(\AppBundle\Entity\Evaluation $evaluation = null)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return \AppBundle\Entity\Evaluation
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }
}
