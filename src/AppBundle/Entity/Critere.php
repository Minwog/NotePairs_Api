<?php

namespace AppBundle\Entity;

/**
 * Critere
 */
class Critere
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $pointsMax;

    /**
     * @var integer
     */
    private $ordre;

    /**
     * @var \AppBundle\Entity\TypeCritere
     */
    private $type;

    /**
     * @var \AppBundle\Entity\Section
     */
    private $section;




    /**
     * @var \AppBundle\Entity\Trapeze
     */

    private $trapeze;

    /**
     * Get id
     * @return integer
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Critere
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
     * Set pointsMax
     *
     * @param string $pointsMax
     *
     * @return Critere
     */
    public function setPointsMax($pointsMax)
    {
        $this->pointsMax = $pointsMax;

        return $this;
    }

    /**
     * Get pointsMax
     *
     * @return string
     */
    public function getPointsMax()
    {
        return $this->pointsMax;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Critere
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
     * Set type
     *
     * @param \AppBundle\Entity\TypeCritere $type
     *
     * @return Critere
     */
    public function setType(\AppBundle\Entity\TypeCritere $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TypeCritere
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Critere
     */
    public function setSection(\AppBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

     /**
      * Get trapeze
      *
      * @return \AppBundle\Entity\Trapeze
      */
    public function getTrapeze()
    {
        return $this->trapeze;
    }


    /**
     * Set trapeze
     *
     * @param \AppBundle\Entity\Trapeze $trapeze
     *
     * @return Critere
     */
    public function setTrapeze($trapeze)
    {
        $this->trapeze = $trapeze;

        return $this;
    }

}
