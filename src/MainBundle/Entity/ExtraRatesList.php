<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExtraRatesList
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ExtraRatesList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="extra_rates", type="integer")
     */
    private $extraRates;

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
     * Set position
     *
     * @param string $position
     * @return ExtraRatesList
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Set extraRates
     *
     * @param integer $extraRates
     * @return ExtraRatesList
     */
    public function setExtraRates($extraRates)
    {
        $this->extraRates = $extraRates;

        return $this;
    }

    /**
     * Get extraRates
     *
     * @return integer 
     */
    public function getExtraRates()
    {
        return $this->extraRates;
    }
}
