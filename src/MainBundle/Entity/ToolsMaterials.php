<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToolsMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ToolsMaterials extends RawMaterials
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
     * @ORM\ManyToOne(targetEntity="ToolsCategory", inversedBy="toolsMaterials", cascade={"persist"})
     */
    private $category;

    //TODO
    /**
     * @ORM\Column(name="repair", type="string", nullable=true)
     */
    protected $repair;

    //TODO
    /**
     * @var string
     *
     * @ORM\Column(name="chronology", type="string", length=255, nullable=true)
     */
    private $chronology;

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
     * Set category
     *
     * @param integer $category
     * @return ToolsMaterials
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set repair
     *
     * @param string $repair
     * @return ToolsMaterials
     */
    public function setRepair($repair)
    {
        $this->repair = $repair;

        return $this;
    }

    /**
     * Get repair
     *
     * @return string 
     */
    public function getRepair()
    {
        return $this->repair;
    }

    /**
     * Set chronology
     *
     * @param string $chronology
     * @return ToolsMaterials
     */
    public function setChronology($chronology)
    {
        $this->chronology = $chronology;

        return $this;
    }

    /**
     * Get chronology
     *
     * @return string 
     */
    public function getChronology()
    {
        return $this->chronology;
    }

    /**
     * Add repair
     *
     * @param \MainBundle\Entity\ToolsCategory $repair
     * @return ToolsMaterials
     */
    public function addRepair(\MainBundle\Entity\ToolsCategory $repair)
    {
        $this->repair[] = $repair;

        return $this;
    }
}
