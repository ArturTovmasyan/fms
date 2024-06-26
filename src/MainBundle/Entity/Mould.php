<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Mould
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, errorPath="code", message="this code is already exist")
 */
class Mould
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
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min=4, max=4)
     * @Assert\Regex("/[0-9]/")
     */
    private $code;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(name="preparation_time", type="datetime")
     */
    private $preparationTime;

    /**
     * @ORM\Column(name="current_state", type="smallint", length=255)
     */
    private $currentState;

    /**
     * @ORM\Column(name="bandwidth", type="integer")
     */
    private $bandwidth;

    /**
     * @ORM\Column(name="last_repair", type="datetime")
     */
    private $lastRepair;

    /**
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @ORM\Column(name="accounting_price", type="integer")
     */
    private $accountingPrice;

    /**
     * @ORM\Column(name="actual_price", type="integer")
     */
    private $actualPrice;

    /**
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(name="over_size", type="string", length=20)
     */
    private $overSize = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="mould", fetch="EXTRA_LAZY")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="mould", cascade={"persist"})
     * @ORM\JoinTable(name="mould_place")
     */
    private $placeWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment", inversedBy="mould")
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity="PurposeList", inversedBy="mould", cascade={"persist"})
     */
    private $purposeList;

    /**
     * @ORM\OneToMany(targetEntity="RouteCard", mappedBy="mould", cascade={"persist"})
     */
    protected $routeCard;

    /**
     * @var integer
     * @ORM\Column(name="general_count", type="integer")
     */
    private $generalCount;

    /**
     * @var integer
     * @ORM\Column(name="mould_type", type="integer", options={"default"=1})
     */
    private $mouldType = 1;

    //relation
//    private $currentOrder;

    //relation
//    private $chronology for SHOW ;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->code) ? (string)$this->code : '';
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
     * Set code
     *
     * @param string $code
     * @return Mould
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

    /**
     * Set description
     *
     * @param string $description
     * @return Mould
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
     * Set preparationTime
     *
     * @param \DateTime $preparationTime
     * @return Mould
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get preparationTime
     *
     * @return \DateTime
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set currentState
     *
     * @param string $currentState
     * @return Mould
     */
    public function setCurrentState($currentState)
    {
        $this->currentState = $currentState;

        return $this;
    }

    /**
     * Get currentState
     *
     * @return string
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * Set bandwidth
     *
     * @param integer $bandwidth
     * @return Mould
     */
    public function setBandwidth($bandwidth)
    {
        $this->bandwidth = $bandwidth;

        return $this;
    }

    /**
     * Get bandwidth
     *
     * @return integer
     */
    public function getBandwidth()
    {
        return $this->bandwidth;
    }

    /**
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return Mould
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
     * Set created
     *
     * @param \DateTime $created
     * @return Mould
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
     * @return Mould
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
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set overSize
     *
     * @param integer $overSize
     * @return Mould
     */
    public function setOverSize($overSize)
    {
        $this->overSize = $overSize;

        return $this;
    }

    /**
     * Get overSize
     *
     * @return integer 
     */
    public function getOverSize()
    {
        return $this->overSize;
    }


    /**
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return Mould
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
     * Set accountingPrice
     *
     * @param integer $accountingPrice
     * @return Mould
     */
    public function setAccountingPrice($accountingPrice)
    {
        $this->accountingPrice = $accountingPrice;

        return $this;
    }

    /**
     * Get accountingPrice
     *
     * @return integer 
     */
    public function getAccountingPrice()
    {
        return $this->accountingPrice;
    }

    /**
     * Set actualPrice
     *
     * @param integer $actualPrice
     * @return Mould
     */
    public function setActualPrice($actualPrice)
    {
        $this->actualPrice = $actualPrice;

        return $this;
    }

    /**
     * Get actualPrice
     *
     * @return integer 
     */
    public function getActualPrice()
    {
        return $this->actualPrice;
    }

    /**
     * This function is used to get mould state string name
     *
     * @return null|string
     */
    public  function getStringState()
    {

        $stringState = null;

        switch($this->currentState) {
            case 0:
                $stringState = "Նորմալ";
                break;
            case 1:
                $stringState = "Վերանորոգման ենթակա";
                break;
            case 2:
                $stringState = "Անպիտան";
                break;
            case 3:
                $stringState = "Ձևափոխված";
                break;

            default:
                $stringState= "";
        }

        return $stringState;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Mould
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

    /**
     * Set purposeList
     *
     * @param \MainBundle\Entity\PurposeList $purposeList
     * @return Mould
     */
    public function setPurposeList(\MainBundle\Entity\PurposeList $purposeList = null)
    {
        $this->purposeList = $purposeList;

        return $this;
    }

    /**
     * Get purposeList
     *
     * @return \MainBundle\Entity\PurposeList 
     */
    public function getPurposeList()
    {
        return $this->purposeList;
    }

    /**
     * Set generalCount
     *
     * @param integer $generalCount
     * @return Mould
     */
    public function setGeneralCount($generalCount)
    {
        $this->generalCount = $generalCount;

        return $this;
    }

    /**
     * Get generalCount
     *
     * @return integer 
     */
    public function getGeneralCount()
    {
        return $this->generalCount;
    }

    /**
     * Add placeWarehouse
     *
     * @param \MainBundle\Entity\PlaceWarehouse $placeWarehouse
     * @return Mould
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
     * Set mouldType
     *
     * @param integer $mouldType
     * @return Mould
     */
    public function setMouldType($mouldType)
    {
        $this->mouldType = $mouldType;

        return $this;
    }

    /**
     * Get mouldType
     *
     * @return integer 
     */
    public function getMouldType()
    {
        return $this->mouldType;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     * @return Mould
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set lastRepair
     *
     * @param \DateTime $lastRepair
     * @return Mould
     */
    public function setLastRepair($lastRepair)
    {
        $this->lastRepair = $lastRepair;

        return $this;
    }

    /**
     * Get lastRepair
     *
     * @return \DateTime 
     */
    public function getLastRepair()
    {
        return $this->lastRepair;
    }

    /**
     * Add routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     * @return Mould
     */
    public function addRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $this->routeCard[] = $routeCard;

        return $this;
    }

    /**
     * Remove routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     */
    public function removeRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $this->routeCard->removeElement($routeCard);
    }

    /**
     * Get routeCard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRouteCard()
    {
        return $this->routeCard;
    }
}
