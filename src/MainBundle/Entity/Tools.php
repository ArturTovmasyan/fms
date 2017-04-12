<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * Tools
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\ToolsRepository")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="This code is already exist")
 */
class Tools
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
     * @ORM\ManyToOne(targetEntity="ToolsCategory", inversedBy="tools", cascade={"persist"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="ToolImages", mappedBy="tool", cascade={"persist", "remove"})
     * @Groups({"files"})
     */
    protected $images;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min = 3, max=3)
     * @Assert\Regex("/[0-9]/")
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="smallint", nullable=true)
     */
    private $size;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="tools", cascade={"persist"})
     * @ORM\JoinTable(name="tools_place")
     */
    protected $placeWarehouse;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer", nullable=true)
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="PartnersList", cascade={"persist"}, inversedBy="tools")
     * @ORM\JoinTable(name="tools_partners_id")
     */
    protected $vendors;

    /**
     * @ORM\Column(name="actual_cost", type="integer", nullable=true)
     */
    private $actualCost = 1;

    /**
     * @ORM\Column(name="balance_cost", type="integer", nullable=true)
     */
    private $balanceCost;

    /**
     * @ORM\OneToMany(targetEntity="ProductRawExpense", mappedBy="rawMaterials", cascade={"persist"})
     */
    protected $productRawExpense;

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
        $this->description = ($description);

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
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get updated
     *
     * @return \DateTime
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

    /**
     * Set category
     *
     * @param \MainBundle\Entity\ToolsCategory $category
     * @return Tools
     */
    public function setCategory(\MainBundle\Entity\ToolsCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MainBundle\Entity\ToolsCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add images
     *
     * @param \MainBundle\Entity\ToolImages $images
     * @return Tools
     */
    public function addImage(\MainBundle\Entity\ToolImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MainBundle\Entity\ToolImages $images
     */
    public function removeImage(\MainBundle\Entity\ToolImages $images)
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
     * @return bool|mixed
     */
    public function getToolImages()
    {
        // get images
        $files = $this->getImages();

        // check images
        if($files){

            return $files;
        }

        return null;
    }
}
