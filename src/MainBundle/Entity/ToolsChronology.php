<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ToolsChronology
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"personnel", "tool"}, errorPath="personnel",
 *                  message= "This person already exist, please select another person")
 */
class ToolsChronology
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
     * @ORM\ManyToOne(targetEntity="Personnel")
     */
    private $personnel;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Tools", inversedBy="toolsChronology", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="tools_id", referencedColumnName="id")
     */
    private $tool;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="from_date", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="to_date", type="datetime", nullable=true)
     */
    private $toDate;

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
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return ToolsChronology
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime 
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     * @return ToolsChronology
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->id ? (string)$this->id : '';
    }

    /**
     * Get toDate
     *
     * @return \DateTime 
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set tool
     *
     * @param \MainBundle\Entity\Tools $tool
     * @return ToolsChronology
     */
    public function setTool(\MainBundle\Entity\Tools $tool = null)
    {
        $this->tool = $tool;

        return $this;
    }

    /**
     * Get tool
     *
     * @return \MainBundle\Entity\Tools 
     */
    public function getTool()
    {
        return $this->tool;
    }

    /**
     * Set personnel
     *
     * @param \MainBundle\Entity\Personnel $personnel
     * @return ToolsChronology
     */
    public function setPersonnel(\MainBundle\Entity\Personnel $personnel = null)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return \MainBundle\Entity\Personnel 
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }
}
