<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\MultipleFileInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MetalMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MetalMaterials extends RawMaterials implements MultipleFileInterface
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
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Regex("/[0-9]/")
     * @Assert\Length(min="6", max="6")
     */
    private $code;

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
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="metalMaterials", cascade={"persist", "remove"})
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

    /**
     * Add images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     * @return MetalMaterials
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

    /**
     * Set code
     *
     * @param string $code
     * @return MetalMaterials
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
