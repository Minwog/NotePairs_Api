<?php

namespace AppBundle\Entity;

/**
 * CoursHasGroupe
 */
class CoursHasGroupe
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Cours
     */
    private $cours;

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
     * Set cours
     *
     * @param \AppBundle\Entity\Cours $courss
     *
     * @return CoursHasGroupe
     */
    public function setCours(\AppBundle\Entity\Cours $courss = null)
    {
        $this->cours = $courss;

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
     * Set groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return CoursHasGroupe
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
