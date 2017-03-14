<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentReport
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EquipmentReport
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
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mechanicState", type="boolean")
     */
    private $mechanicState;

    /**
     * @var boolean
     *
     * @ORM\Column(name="electricState", type="boolean")
     */
    private $electricState;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidravlik", type="boolean")
     */
    private $hidravlik;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mechanic", type="boolean")
     */
    private $mechanic;

    /**
     * @var boolean
     *
     * @ORM\Column(name="electric", type="boolean")
     */
    private $electric;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accept", type="boolean")
     */
    private $accept;


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
     * Set number
     *
     * @param integer $number
     * @return EquipmentReport
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set mechanicState
     *
     * @param boolean $mechanicState
     * @return EquipmentReport
     */
    public function setMechanicState($mechanicState)
    {
        $this->mechanicState = $mechanicState;

        return $this;
    }

    /**
     * Get mechanicState
     *
     * @return boolean 
     */
    public function getMechanicState()
    {
        return $this->mechanicState;
    }

    /**
     * Set electricState
     *
     * @param boolean $electricState
     * @return EquipmentReport
     */
    public function setElectricState($electricState)
    {
        $this->electricState = $electricState;

        return $this;
    }

    /**
     * Get electricState
     *
     * @return boolean 
     */
    public function getElectricState()
    {
        return $this->electricState;
    }

    /**
     * Set hidravlik
     *
     * @param boolean $hidravlik
     * @return EquipmentReport
     */
    public function setHidravlik($hidravlik)
    {
        $this->hidravlik = $hidravlik;

        return $this;
    }

    /**
     * Get hidravlik
     *
     * @return boolean 
     */
    public function getHidravlik()
    {
        return $this->hidravlik;
    }

    /**
     * Set mechanic
     *
     * @param boolean $mechanic
     * @return EquipmentReport
     */
    public function setMechanic($mechanic)
    {
        $this->mechanic = $mechanic;

        return $this;
    }

    /**
     * Get mechanic
     *
     * @return boolean 
     */
    public function getMechanic()
    {
        return $this->mechanic;
    }

    /**
     * Set electric
     *
     * @param boolean $electric
     * @return EquipmentReport
     */
    public function setElectric($electric)
    {
        $this->electric = $electric;

        return $this;
    }

    /**
     * Get electric
     *
     * @return boolean 
     */
    public function getElectric()
    {
        return $this->electric;
    }

    /**
     * Set accept
     *
     * @param boolean $accept
     * @return EquipmentReport
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Get accept
     *
     * @return boolean 
     */
    public function getAccept()
    {
        return $this->accept;
    }
}
