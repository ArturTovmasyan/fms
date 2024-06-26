<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\MultipleFileInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * RubberMaterials
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\RubberMaterialsRepository")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="This code is already exist")
 */
class RubberMaterials extends RawMaterials implements MultipleFileInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="gost", type="string", length=255, nullable=true)
     */
    private $gost;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min="6", max="6")
     * @Assert\Regex("/[0-9]/")
     */
    private $code;
    
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
     * @Groups({"files"})
     */
    protected $images;

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

    /**
     * Set code
     *
     * @param string $code
     * @return RubberMaterials
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
