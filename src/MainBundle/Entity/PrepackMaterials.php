<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PrepackMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PrepackMaterials
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
     * @Assert\Length(min="4")
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="smallint")
     */
    private $size;

    //TODO
    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="prepackMaterials", cascade={"persist"})
     * @ORM\JoinTable(name="prepack_place")
     */
    protected $placeWarehouse;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer")
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="PartnersList", cascade={"persist"}, inversedBy="prepackMaterials")
     * @ORM\JoinTable(name="prepack_materials_partners")
     */
    protected $vendors;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment")
     */
    protected $equipment;

    /**
     * @var integer
     *
     * @ORM\Column(name="workshop", type="smallint")
     */
    private $workshop;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

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

//    private $images;

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
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
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
     * @param $workshop
     * @return $this
     */
    public function setWorkshop($workshop)
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop
     *
     * @return integer 
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vendors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     * @return PrepackMaterials
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
     * @return PrepackMaterials
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
     * Get vendors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return PrepackMaterials
     */
    public function addProduct(\MainBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \MainBundle\Entity\Product $product
     */
    public function removeProduct(\MainBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return PrepackMaterials
     */
    public function addEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return PrepackMaterials
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
