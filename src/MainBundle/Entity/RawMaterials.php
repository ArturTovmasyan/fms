<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RawMaterials
 *
 * @ORM\Table(name="raw_materials")
 * @ORM\Entity()
 * @UniqueEntity(fields={"code"}, errorPath="code", message="this code is already exist")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class_name", type="string")
 * @ORM\DiscriminatorMap({"rawMaterials" = "RawMaterials",
 *                        "rubberMaterials" = "RubberMaterials",
 *                        "toolsMaterials" = "ToolsMaterials",
 *                        "metalMaterials" = "MetalMaterials",
 *                        "conductiveMaterials" = "ConductiveMaterials",
 *                        "illiquidMaterials" = "IlliquidMaterials",
 *                        "householdMaterials" = "HouseholdMaterials"})
 */
abstract class RawMaterials
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min = 4)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="smallint")
     */
    private $size;

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
     * @ORM\ManyToMany(targetEntity="Client", cascade={"persist"}, inversedBy="rawMaterials")
     * @ORM\JoinTable(name="raw_materials_client")
     */
    private $vendors;

    /**
     * @ORM\Column(name="actual_cost", type="integer")
     */
    private $actualCost;

    /**
     * @ORM\Column(name="balance_cost", type="integer")
     */
    private $balanceCost;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Gallery", cascade={"remove","persist"})
     */
    private $technicalFile;

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
     * @return RawMaterials
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
     * @return RawMaterials
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
     * @return RawMaterials
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
     * Set size
     *
     * @param integer $size
     * @return RawMaterials
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
     * Set countInWarehouse
     *
     * @param string $countInWarehouse
     * @return RawMaterials
     */
    public function setCountInWarehouse($countInWarehouse)
    {
        $this->countInWarehouse = $countInWarehouse;

        return $this;
    }

    /**
     * Get countInWarehouse
     *
     * @return string 
     */
    public function getCountInWarehouse()
    {
        return $this->countInWarehouse;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return RawMaterials
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set vendors
     *
     * @param string $vendors
     * @return RawMaterials
     */
    public function setVendors($vendors)
    {
        $this->vendors = $vendors;

        return $this;
    }

    /**
     * Get vendors
     *
     * @return string 
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * Set actualCost
     *
     * @param string $actualCost
     * @return RawMaterials
     */
    public function setActualCost($actualCost)
    {
        $this->actualCost = $actualCost;

        return $this;
    }

    /**
     * Get actualCost
     *
     * @return string 
     */
    public function getActualCost()
    {
        return $this->actualCost;
    }

    /**
     * Set balanceCost
     *
     * @param string $balanceCost
     * @return RawMaterials
     */
    public function setBalanceCost($balanceCost)
    {
        $this->balanceCost = $balanceCost;

        return $this;
    }

    /**
     * Get balanceCost
     *
     * @return string 
     */
    public function getBalanceCost()
    {
        return $this->balanceCost;
    }

    /**
     * Set technicalFile
     *
     * @param string $technicalFile
     * @return RawMaterials
     */
    public function setTechnicalFile($technicalFile)
    {
        $this->technicalFile = $technicalFile;

        return $this;
    }

    /**
     * Get technicalFile
     *
     * @return string 
     */
    public function getTechnicalFile()
    {
        return $this->technicalFile;
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
     * Constructor
     */
    public function __construct()
    {
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vendors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
    }

    /**
     * Add placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     * @return RawMaterials
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
     * Add vendors
     *
     * @param \MainBundle\Entity\Client $vendors
     * @return RawMaterials
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
     * Set created
     *
     * @param \DateTime $created
     * @return RawMaterials
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
     * @return RawMaterials
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
}
