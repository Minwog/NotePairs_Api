<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * Section
 */
class Trapeze
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $point1;

    /**
     * @var float
     */
    private $point2;

    /**
     * @var float
     */
    private $point3;

    /**
     * @var float
     */
    private $point4;

    /**
     * @var \AppBundle\Entity\Critere
     */

    private $critere;

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
     * Set point1
     *
     * @param float $point1
     *
     * @return Trapeze
     */
    public function setPoint1($point1)
    {
        $this->point1= $point1;

        return $this;
    }

    /**
     * Get point1
     *
     * @return float
     */
    public function getPoint1()
    {
        return $this->point1;
    }

    /**
     * Set point2
     *
     * @param float $point2
     *
     * @return Trapeze
     */
    public function setPoint2($point2)
    {
        $this->point2= $point2;

        return $this;
    }

    /**
     * Get point2
     *
     * @return float
     */
    public function getPoint2()
    {
        return $this->point2;
    }

    /**
     * Set point3
     *
     * @param float $point3
     *
     * @return Trapeze
     */
    public function setPoint3($point3)
    {
        $this->point3= $point3;

        return $this;
    }

    /**
     * Get point3
     *
     * @return float
     */
    public function getPoint3()
    {
        return $this->point3;
    }

    /**
     * Set point4
     *
     * @param float $point4
     *
     * @return Trapeze
     */
    public function setPoint4($point4)
    {
        $this->point4= $point4;

        return $this;
    }

    /**
     * Get point4
     *
     * @return float
     */
    public function getPoint4()
    {
        return $this->point4;
    }

    /**
     * Get critere
     *
     * @return \AppBundle\Entity\Critere
     */

    public function getCritere(){
    return $this->critere;
    }

    /**
     * Set Critere
     * @param \AppBundle\Entity\Critere $critere
     *
     * @return Trapeze
     */

    public function setCritere($critere){
        $this->critere=$critere;
        return $this;
    }
}