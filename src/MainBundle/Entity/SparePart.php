<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SparePart
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SparePart
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
     * @ORM\Column(name="size", type="smallint")
     */
    private $size;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="sparePart", cascade={"persist"})
     * @ORM\JoinTable(name="spare_part_place")
     */
    protected $placeWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment")
     */
    protected $equipment;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer")
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="PartnersList", cascade={"persist"}, inversedBy="sparePart")
     * @ORM\JoinTable(name="spare_part_partners")
     */
    protected $vendors;

    /**
     * @ORM\Column(name="actual_cost", type="integer", nullable=false)
     */
    private $actualCost = 1;

    /**
     * @ORM\Column(name="balance_cost", type="integer")
     */
    private $balanceCost;

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
     * Constructor
     */
    public function __construct()
    {
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vendors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SparePart
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
     * @return SparePart
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
     * @return SparePart
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
     * @param integer $countInWarehouse
     * @return SparePart
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
     * Set actualCost
     *
     * @param integer $actualCost
     * @return SparePart
     */
    public function setActualCost($actualCost)
    {
        $this->actualCost = $actualCost;

        return $this;
    }

    /**
     * Get actualCost
     *
     * @return integer 
     */
    public function getActualCost()
    {
        return $this->actualCost;
    }

    /**
     * Set balanceCost
     *
     * @param integer $balanceCost
     * @return SparePart
     */
    public function setBalanceCost($balanceCost)
    {
        $this->balanceCost = $balanceCost;

        return $this;
    }

    /**
     * Get balanceCost
     *
     * @return integer 
     */
    public function getBalanceCost()
    {
        return $this->balanceCost;
    }

    /**
     * Add placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     * @return SparePart
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
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return SparePart
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
     * Add vendors
     *
     * @param \MainBundle\Entity\PartnersList $vendors
     * @return SparePart
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
}
