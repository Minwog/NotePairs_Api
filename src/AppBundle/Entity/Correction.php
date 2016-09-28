<?php

namespace AppBundle\Entity;

/**
 * Correction
 */
class Correction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateCorrection;

    /**
     * @var string
     */
    private $fiabilite;

    /**
     * @var string
     */
    private $note;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Copie
     */
    private $copie;

    /**
     * @var \AppBundle\Entity\Groupe
     */
    private $groupe;


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
     * Set dateCorrection
     *
     * @param \DateTime $dateCorrection
     *
     * @return Correction
     */
    public function setDateCorrection($dateCorrection)
    {
        $this->dateCorrection = $dateCorrection;

        return $this;
    }

    /**
     * Get dateCorrection
     *
     * @return \DateTime
     */
    public function getDateCorrection()
    {
        return $this->dateCorrection;
    }

    /**
     * Set fiabilite
     *
     * @param string $fiabilite
     *
     * @return Correction
     */
    public function setFiabilite($fiabilite)
    {
        $this->fiabilite = $fiabilite;

        return $this;
    }

    /**
     * Get fiabilite
     *
     * @return string
     */
    public function getFiabilite()
    {
        return $this->fiabilite;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Correction
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Correction
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set copie
     *
     * @param \AppBundle\Entity\Copie $copie
     *
     * @return Correction
     */
    public function setCopie(\AppBundle\Entity\Copie $copie = null)
    {
        $this->copie = $copie;

        return $this;
    }

    /**
     * Get copie
     *
     * @return \AppBundle\Entity\Copie
     */
    public function getCopie()
    {
        return $this->copie;
    }

    /**
     * Set groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return Correction
     */
    public function setGroupe(\AppBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \AppBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }
}
