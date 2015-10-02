<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MetalMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MetalMaterials extends RawMaterials
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
     * @ORM\Column(name="gost", type="string", length=255)
     */
    private $gost;

    /**
     * @ORM\ManyToOne(targetEntity="MetalCategory", inversedBy="metalMaterials", cascade={"persist"})
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimalVolume", type="integer")
     */
    private $minimalVolume;

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
     * Set gost
     *
     * @param string $gost
     * @return MetalMaterials
     */
    public function setGost($gost)
    {
        $this->gost = $gost;

        return $this;
    }

    /**
     * Get gost
     *
     * @return string 
     */
    public function getGost()
    {
        return $this->gost;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return MetalMaterials
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set minimalVolume
     *
     * @param integer $minimalVolume
     * @return MetalMaterials
     */
    public function setMinimalVolume($minimalVolume)
    {
        $this->minimalVolume = $minimalVolume;

        return $this;
    }

    /**
     * Get minimalVolume
     *
     * @return integer 
     */
    public function getMinimalVolume()
    {
        return $this->minimalVolume;
    }
}
