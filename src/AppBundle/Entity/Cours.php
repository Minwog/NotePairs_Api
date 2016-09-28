<?php

namespace AppBundle\Entity;

/**
 * Cours
 */
class Cours
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
     * @var binary
     */
    private $restreint;

    /**
     * @var \AppBundle\Entity\Categorie
     */
    private $categorie;


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
     * @return Cours
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
     * Set restreint
     *
     * @param binary $restreint
     *
     * @return Cours
     */
    public function setRestreint($restreint)
    {
        $this->restreint = $restreint;

        return $this;
    }

    /**
     * Get restreint
     *
     * @return binary
     */
    public function getRestreint()
    {
        return $this->restreint;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Cours
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
