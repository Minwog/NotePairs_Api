<?php

namespace AppBundle\Entity;

/**
 * Parametre
 */
class Parametre
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $extension;


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
     * Set extension
     *
     * @param string $extension
     *
     * @return Parametre
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }
}
