<?php

namespace AppBundle\Entity;

/**
 * Evaluation
 */
class Evaluation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var \DateTime
     */
    private $dateRendu;

    /**
     * @var \DateTime
     */
    private $dateFinCorrection;

    /**
     * @var integer
     */
    private $nombreEval;

    /**
     * @var binary
     */
    private $anonymat;

    /**
     * @var binary
     */
    private $isCalibration;

    /**
     * @var binary
     */
    private $isCalculBiais;

    /**
     * @var string
     */
    private $autoevaluation;

    /**
     * @var string
     */
    private $modeEval;

    /**
     * @var string
     */
    private $modeAttribution;

    /**
     * @var binary
     */
    private $travailIndividuel;

    /**
     * @var binary
     */
    private $correctionIndividuelle;

    /**
     * @var \AppBundle\Entity\User
     */
    private $enseignant;

    /**
     * @var \AppBundle\Entity\Cours
     */
    private $cours;

    /**
     * @var \AppBundle\Entity\ModeCalcul
     */
    private $modeCalcul;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Evaluation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateRendu
     *
     * @param \DateTime $dateRendu
     *
     * @return Evaluation
     */
    public function setDateRendu($dateRendu)
    {
        $this->dateRendu = $dateRendu;

        return $this;
    }

    /**
     * Get dateRendu
     *
     * @return \DateTime
     */
    public function getDateRendu()
    {
        return $this->dateRendu;
    }

    /**
     * Set dateFinCorrection
     *
     * @param \DateTime $dateFinCorrection
     *
     * @return Evaluation
     */
    public function setDateFinCorrection($dateFinCorrection)
    {
        $this->dateFinCorrection = $dateFinCorrection;

        return $this;
    }

    /**
     * Get dateFinCorrection
     *
     * @return \DateTime
     */
    public function getDateFinCorrection()
    {
        return $this->dateFinCorrection;
    }

    /**
     * Set nombreEval
     *
     * @param integer $nombreEval
     *
     * @return Evaluation
     */
    public function setNombreEval($nombreEval)
    {
        $this->nombreEval = $nombreEval;

        return $this;
    }

    /**
     * Get nombreEval
     *
     * @return integer
     */
    public function getNombreEval()
    {
        return $this->nombreEval;
    }

    /**
     * Set anonymat
     *
     * @param binary $anonymat
     *
     * @return Evaluation
     */
    public function setAnonymat($anonymat)
    {
        $this->anonymat = $anonymat;

        return $this;
    }

    /**
     * Get anonymat
     *
     * @return binary
     */
    public function getAnonymat()
    {
        return $this->anonymat;
    }

    /**
     * Set isCalibration
     *
     * @param binary $isCalibration
     *
     * @return Evaluation
     */
    public function setIsCalibration($isCalibration)
    {
        $this->isCalibration = $isCalibration;

        return $this;
    }

    /**
     * Get isCalibration
     *
     * @return binary
     */
    public function getIsCalibration()
    {
        return $this->isCalibration;
    }

    /**
     * Set isCalculBiais
     *
     * @param binary $isCalculBiais
     *
     * @return Evaluation
     */
    public function setIsCalculBiais($isCalculBiais)
    {
        $this->isCalculBiais = $isCalculBiais;

        return $this;
    }

    /**
     * Get isCalculBiais
     *
     * @return binary
     */
    public function getIsCalculBiais()
    {
        return $this->isCalculBiais;
    }

    /**
     * Set autoevaluation
     *
     * @param string $autoevaluation
     *
     * @return Evaluation
     */
    public function setAutoevaluation($autoevaluation)
    {
        $this->autoevaluation = $autoevaluation;

        return $this;
    }

    /**
     * Get autoevaluation
     *
     * @return string
     */
    public function getAutoevaluation()
    {
        return $this->autoevaluation;
    }

    /**
     * Set modeEval
     *
     * @param string $modeEval
     *
     * @return Evaluation
     */
    public function setModeEval($modeEval)
    {
        $this->modeEval = $modeEval;

        return $this;
    }

    /**
     * Get modeEval
     *
     * @return string
     */
    public function getModeEval()
    {
        return $this->modeEval;
    }

    /**
     * Set modeAttribution
     *
     * @param string $modeAttribution
     *
     * @return Evaluation
     */
    public function setModeAttribution($modeAttribution)
    {
        $this->modeAttribution = $modeAttribution;

        return $this;
    }

    /**
     * Get modeAttribution
     *
     * @return string
     */
    public function getModeAttribution()
    {
        return $this->modeAttribution;
    }

    /**
     * Set travailIndividuel
     *
     * @param binary $travailIndividuel
     *
     * @return Evaluation
     */
    public function setTravailIndividuel($travailIndividuel)
    {
        $this->travailIndividuel = $travailIndividuel;

        return $this;
    }

    /**
     * Get travailIndividuel
     *
     * @return binary
     */
    public function getTravailIndividuel()
    {
        return $this->travailIndividuel;
    }

    /**
     * Set correctionIndividuelle
     *
     * @param binary $correctionIndividuelle
     *
     * @return Evaluation
     */
    public function setCorrectionIndividuelle($correctionIndividuelle)
    {
        $this->correctionIndividuelle = $correctionIndividuelle;

        return $this;
    }

    /**
     * Get correctionIndividuelle
     *
     * @return binary
     */
    public function getCorrectionIndividuelle()
    {
        return $this->correctionIndividuelle;
    }

    /**
     * Set enseignant
     *
     * @param \AppBundle\Entity\User $enseignant
     *
     * @return Evaluation
     */
    public function setEnseignant(\AppBundle\Entity\User $enseignant = null)
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * Get enseignant
     *
     * @return \AppBundle\Entity\User
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * Set cours
     *
     * @param \AppBundle\Entity\Cours $cours
     *
     * @return Evaluation
     */
    public function setCours(\AppBundle\Entity\Cours $cours = null)
    {
        $this->cours = $cours;

        return $this;
    }

    /**
     * Get cours
     *
     * @return \AppBundle\Entity\Cours
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * Set modeCalcul
     *
     * @param \AppBundle\Entity\ModeCalcul $modeCalcul
     *
     * @return Evaluation
     */
    public function setModeCalcul(\AppBundle\Entity\ModeCalcul $modeCalcul = null)
    {
        $this->modeCalcul = $modeCalcul;

        return $this;
    }

    /**
     * Get modeCalcul
     *
     * @return \AppBundle\Entity\ModeCalcul
     */
    public function getModeCalcul()
    {
        return $this->modeCalcul;
    }
}
