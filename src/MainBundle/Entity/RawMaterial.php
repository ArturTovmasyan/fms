<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RawMaterial
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, errorPath="code", message="this code is already exist")
 */
class RawMaterial
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
     * @var string
     *
     * @ORM\Column(name="gost", type="string", length=255, nullable=true)
     */
    private $gost;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min = 6)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Gallery", cascade={"remove","persist"})
     */
    private $technicalFile;

    /**
     * @ORM\ManyToOne(targetEntity="RawCategory", inversedBy="rawMaterial", cascade={"persist"})
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Client", cascade={"persist"}, inversedBy="rawMaterials")
     * @ORM\JoinTable(name="raw_materials_client")
     */
    private $vendors;

//for operation card
//    private $product;

//    private $price;

    /**
     * @ORM\Column(name="size", type="smallint")
     */
    private $size;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimalVolume", type="integer")
     */
    private $minimalVolume;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="rawMaterials", cascade={"persist"})
     * @ORM\JoinTable(name="raw_place")
     */
    private $placeWarehouse;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer")
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    private $image;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
    }

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
     * @return RawMaterial
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
     * Set description
     *
     * @param string $description
     * @return RawMaterial
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
     * Set code
     *
     * @param integer $code
     * @return RawMaterial
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set minimalVolume
     *
     * @param integer $minimalVolume
     * @return RawMaterial
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
     * Set countInWarehouse
     *
     * @param integer $countInWarehouse
     * @return RawMaterial
     */
    public function setCountInWarehouse($countInWarehouse)
    {
        $this->countInWarehouse = $countInWarehouse;

        return $this;
    }

    /**
     * Get countInWarehouse
     *
     * @return integer
     */
    public function getCountInWarehouse()
    {
        return $this->countInWarehouse;
    }

    /**
     * Set image
     *
     * @param integer $image
     * @return RawMaterial
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return integer
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gost
     *
     * @param string $gost
     * @return RawMaterial
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
     * Set size
     *
     * @param integer $size
     * @return RawMaterial
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     * @return RawMaterial
     */
    public function addPlaceWarehouse(\MainBundle\Entity\PlaceWarehouse $placeWarehouse)
    {
        $this->placeWarehouse[] = $placeWarehouse;

        return $this;
    }

    /**
     * Remove placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     */
    public function removePlaceWarehouse(\MainBundle\Entity\PlaceWarehouse $placeWarehouse)
    {
        $this->placeWarehouse->removeElement($placeWarehouse);
    }

    /**
     * Get placeWarehouse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaceWarehouse()
    {
        return $this->placeWarehouse;
    }

    /**
     * This function is used to get material size string name
     *
     * @return null|string
     */
    public function getStringSize()
    {

        $stringSize = null;

        switch($this->size) {
            case 0:
                $stringSize = "Կգ";
                break;
            case 1:
                $stringSize = "Մետր";
                break;
            case 2:
                $stringSize = "Հատ";
                break;
            case 3:
                $stringSize = "Կոմպլեկտ";
                break;
            case 4:
                $stringSize = "Լիտր";
                break;

            default:
                $stringSize= "";
        }

        return $stringSize;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return RawMaterial
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return RawMaterial
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Add vendors
     *
     * @param \MainBundle\Entity\Client $vendors
     * @return RawMaterial
     */
    public function addVendor(\MainBundle\Entity\Client $vendors)
    {
        $this->vendors[] = $vendors;

        return $this;
    }

    /**
     * Remove vendors
     *
     * @param \MainBundle\Entity\Client $vendors
     */
    public function removeVendor(\MainBundle\Entity\Client $vendors)
    {
        $this->vendors->removeElement($vendors);
    }

    /**
     * Get vendors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * Set technicalFile
     *
     * @param \Application\MediaBundle\Entity\Gallery $technicalFile
     * @return RawMaterial
     */
    public function setTechnicalFile(\Application\MediaBundle\Entity\Gallery $technicalFile = null)
    {
        $this->technicalFile = $technicalFile;

        return $this;
    }

    /**
     * Get technicalFile
     *
     * @return \Application\MediaBundle\Entity\Gallery 
     */
    public function getTechnicalFile()
    {
        return $this->technicalFile;
    }

    /**
     * Set category
     *
     * @param \MainBundle\Entity\RawCategory $category
     * @return RawMaterial
     */
    public function setCategory(\MainBundle\Entity\RawCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MainBundle\Entity\RawCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
