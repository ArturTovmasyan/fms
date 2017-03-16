<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RubberMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RubberMaterials extends RawMaterials
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
     * @ORM\Column(name="gost", type="string", length=255, nullable=true)
     */
    private $gost;

    /**
     * @ORM\ManyToOne(targetEntity="RubberCategory", inversedBy="rubberMaterials", cascade={"persist"})
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimalVolume", type="integer")
     */
    private $minimalVolume;

    /**
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="rubberMaterials", cascade={"persist", "remove"})
     */
    protected $images;

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
     * Set minimalVolume
     *
     * @param integer $minimalVolume
     * @return RubberMaterials
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

    /**
     * Set gost
     *
     * @param string $gost
     * @return RubberMaterials
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
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set category
     *
     * @param \MainBundle\Entity\RubberCategory $category
     * @return RubberMaterials
     */
    public function setCategory(\MainBundle\Entity\RubberCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MainBundle\Entity\RubberCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     * @return RubberMaterials
     */
    public function addImage(\MainBundle\Entity\RawMaterialImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     */
    public function removeImage(\MainBundle\Entity\RawMaterialImages $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
