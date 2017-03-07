<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToolsCategory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ToolsCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Tools", mappedBy="category", cascade={"persist"})
     */
    private $tools;

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
     * Set name
     *
     * @param string $name
     * @return ToolsCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tools = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tools
     *
     * @param \MainBundle\Entity\Tools $tools
     * @return ToolsCategory
     */
    public function addTool(\MainBundle\Entity\Tools $tools)
    {
        $this->tools[] = $tools;

        return $this;
    }

    /**
     * Remove tools
     *
     * @param \MainBundle\Entity\Tools $tools
     */
    public function removeTool(\MainBundle\Entity\Tools $tools)
    {
        $this->tools->removeElement($tools);
    }

    /**
     * Get tools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTools()
    {
        return $this->tools;
    }
}
