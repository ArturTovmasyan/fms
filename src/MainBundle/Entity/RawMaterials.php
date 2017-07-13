<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * RawMaterials
 *
 * @ORM\Table(name="raw_materials")
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\RawMaterialsRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class_name", type="string")
 * @ORM\DiscriminatorMap({"rawMaterials" = "RawMaterials",
 *                        "rubberMaterials" = "RubberMaterials",
 *                        "prepackMaterials" = "PrepackMaterials",
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
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
     * @ORM\Column(name="size", type="smallint")
     */
    private $size;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="rawMaterials", cascade={"persist"})
     * @ORM\JoinTable(name="raw_place")
     */
    protected $placeWarehouse;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer")
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="PartnersList", cascade={"persist"}, inversedBy="rawMaterials")
     * @ORM\JoinTable(name="raw_materials_partners")
     */
    protected $vendors;

    /**
     * @ORM\Column(name="actual_cost", type="integer")
     */
    private $actualCost = 0;

    /**
     * @ORM\Column(name="balance_cost", type="integer")
     */
    private $balanceCost = 0;

    /**
     * @ORM\OneToMany(targetEntity="ProductRawExpense", mappedBy="rawMaterials", cascade={"persist", "remove"})
     */
    protected $productRawExpense;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
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
     * This function is used to get material size string name
     *
     * @return null|string
     */
    public function getStringSize()
    {

        $stringSize = null;

        switch($this->getSize()) {
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
     * @param \MainBundle\Entity\PartnersList $vendors
     * @return RawMaterials
     */
    public function addVendor(\MainBundle\Entity\PartnersList $vendors)
    {
        $this->vendors[] = $vendors;

        return $this;
    }

    /**
     * Remove vendors
     *
     * @param \MainBundle\Entity\PartnersList $vendors
     */
    public function removeVendor(\MainBundle\Entity\PartnersList $vendors)
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
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Add productRawExpense
     *
     * @param \MainBundle\Entity\ProductRawExpense $productRawExpense
     * @return RawMaterials
     */
    public function addProductRawExpense(\MainBundle\Entity\ProductRawExpense $productRawExpense)
    {
        $this->productRawExpense[] = $productRawExpense;

        return $this;
    }

    /**
     * Remove productRawExpense
     *
     * @param \MainBundle\Entity\ProductRawExpense $productRawExpense
     */
    public function removeProductRawExpense(\MainBundle\Entity\ProductRawExpense $productRawExpense)
    {
        $this->productRawExpense->removeElement($productRawExpense);
    }

    /**
     * Get productRawExpense
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductRawExpense()
    {
        return $this->productRawExpense;
    }

############################################## This part code for upload files in child entities ##########################
    /**
     * @return array
     */
    public function  getMaterialMultipleFile()
    {
        // check images and return array
        if($this->images){

            return $this->images->toArray();
        }
        return [];
    }

    /**
     * @param $multipleFile
     */
    public function  setMaterialMultipleFile($multipleFile)
    {
        // check added images
        if(count($multipleFile) > 0){

            $this->images = new ArrayCollection($multipleFile);
        }
    }

    /**
     * @return bool|mixed
     */
    public function getMaterialImages()
    {
        // get images
        $files = $this->getImages();

        // check images
        if($files){

            return $files;
        }

        return null;
    }
#########################################################################################################################

}
