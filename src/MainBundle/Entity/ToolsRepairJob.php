<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ToolsRepairJob
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ToolsRepairJob
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

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
     * @ORM\ManyToOne(targetEntity="Tools", inversedBy="toolsRepairJob", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="tools_id", referencedColumnName="id")
     */
    private $tool;

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
     * @return string
     */
    function __toString()
    {
        return (string)$this->id ? (string)$this->id : '';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ToolsRepairJob
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
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return ToolsRepairJob
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
     * @return ToolsRepairJob
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;

        return $this;
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
     * @return ToolsRepairJob
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
}
