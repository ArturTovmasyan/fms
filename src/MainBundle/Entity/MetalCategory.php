<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MetalCategory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MetalCategory
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
     * @ORM\OneToMany(targetEntity="MetalMaterials", mappedBy="category", cascade={"persist"})
     */
    protected $metalMaterials;

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
     * @return MetalCategory
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
        $this->metalMaterials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add metalMaterials
     *
     * @param \MainBundle\Entity\MetalMaterials $metalMaterials
     * @return MetalCategory
     */
    public function addMetalMaterial(\MainBundle\Entity\MetalMaterials $metalMaterials)
    {
        $this->metalMaterials[] = $metalMaterials;

        return $this;
    }

    /**
     * Remove metalMaterials
     *
     * @param \MainBundle\Entity\MetalMaterials $metalMaterials
     */
    public function removeMetalMaterial(\MainBundle\Entity\MetalMaterials $metalMaterials)
    {
        $this->metalMaterials->removeElement($metalMaterials);
    }

    /**
     * Get metalMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetalMaterials()
    {
        return $this->metalMaterials;
    }
}
