<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repair
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Repair
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
     * @var \DateTime
     *
     * @ORM\Column(name="lastDate", type="datetime")
     */
    private $lastDate;

    /**
     * @var string
     *
     * @ORM\Column(name="repairDescription", type="string", length=255)
     */
    private $repairDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="doDate", type="datetime")
     */
    private $doDate;

    /**
     * @var string
     *
     * @ORM\Column(name="doDescription", type="string", length=255)
     */
    private $doDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="doPerson", type="string", length=255)
     */
    private $doPerson;


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
     * Set lastDate
     *
     * @param \DateTime $lastDate
     * @return Repair
     */
    public function setLastDate($lastDate)
    {
        $this->lastDate = $lastDate;

        return $this;
    }

    /**
     * Get lastDate
     *
     * @return \DateTime 
     */
    public function getLastDate()
    {
        return $this->lastDate;
    }

    /**
     * Set repairDescription
     *
     * @param string $repairDescription
     * @return Repair
     */
    public function setRepairDescription($repairDescription)
    {
        $this->repairDescription = $repairDescription;

        return $this;
    }

    /**
     * Get repairDescription
     *
     * @return string 
     */
    public function getRepairDescription()
    {
        return $this->repairDescription;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Repair
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
     * Set doDate
     *
     * @param \DateTime $doDate
     * @return Repair
     */
    public function setDoDate($doDate)
    {
        $this->doDate = $doDate;

        return $this;
    }

    /**
     * Get doDate
     *
     * @return \DateTime 
     */
    public function getDoDate()
    {
        return $this->doDate;
    }

    /**
     * Set doDescription
     *
     * @param string $doDescription
     * @return Repair
     */
    public function setDoDescription($doDescription)
    {
        $this->doDescription = $doDescription;

        return $this;
    }

    /**
     * Get doDescription
     *
     * @return string 
     */
    public function getDoDescription()
    {
        return $this->doDescription;
    }

    /**
     * Set doPerson
     *
     * @param string $doPerson
     * @return Repair
     */
    public function setDoPerson($doPerson)
    {
        $this->doPerson = $doPerson;

        return $this;
    }

    /**
     * Get doPerson
     *
     * @return string 
     */
    public function getDoPerson()
    {
        return $this->doPerson;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ((int)$this->number) ? (int)$this->number : 0;
    }
}
