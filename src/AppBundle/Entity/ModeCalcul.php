<?php

namespace AppBundle\Entity;

/**
 * ModeCalcul
 */
class ModeCalcul
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $mode;


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
     * Set mode
     *
     * @param string $mode
     *
     * @return ModeCalcul
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
}
