<?php

namespace AppBundle\Entity;

/**
 * CorrigeCritere
 */
class CorrigeCritere
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $precision;

    /**
     * @var string
     */
    private $commentaire;

    /**
     * @var \AppBundle\Entity\Critere
     */
    private $critere;

    /**
     * @var \AppBundle\Entity\Correction
     */
    private $correction;


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
     * Set note
     *
     * @param string $note
     *
     * @return CorrigeCritere
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set precision
     *
     * @param string $precision
     *
     * @return CorrigeCritere
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Get precision
     *
     * @return string
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return CorrigeCritere
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set critere
     *
     * @param \AppBundle\Entity\Critere $critere
     *
     * @return CorrigeCritere
     */
    public function setCritere(\AppBundle\Entity\Critere $critere = null)
    {
        $this->critere = $critere;

        return $this;
    }

    /**
     * Get critere
     *
     * @return \AppBundle\Entity\Critere
     */
    public function getCritere()
    {
        return $this->critere;
    }

    /**
     * Set correction
     *
     * @param \AppBundle\Entity\Correction $correction
     *
     * @return CorrigeCritere
     */
    public function setCorrection(\AppBundle\Entity\Correction $correction = null)
    {
        $this->correction = $correction;

        return $this;
    }

    /**
     * Get correction
     *
     * @return \AppBundle\Entity\Correction
     */
    public function getCorrection()
    {
        return $this->correction;
    }
}
