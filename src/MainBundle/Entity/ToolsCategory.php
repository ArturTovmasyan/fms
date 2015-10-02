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
     * @ORM\OneToMany(targetEntity="ToolsMaterials", mappedBy="category", cascade={"persist"})
     */
    protected  $toolsMaterials;

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
        $this->toolsMaterials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add toolsMaterials
     *
     * @param \MainBundle\Entity\ToolsMaterials $toolsMaterials
     * @return ToolsCategory
     */
    public function addToolsMaterial(\MainBundle\Entity\ToolsMaterials $toolsMaterials)
    {
        $this->toolsMaterials[] = $toolsMaterials;

        return $this;
    }

    /**
     * Remove toolsMaterials
     *
     * @param \MainBundle\Entity\ToolsMaterials $toolsMaterials
     */
    public function removeToolsMaterial(\MainBundle\Entity\ToolsMaterials $toolsMaterials)
    {
        $this->toolsMaterials->removeElement($toolsMaterials);
    }

    /**
     * Get toolsMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getToolsMaterials()
    {
        return $this->toolsMaterials;
    }
}
