<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Mould
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="code", type="integer", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min="4")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="preparation_time", type="datetime")
     */
    private $preparationTime;

    /**
     * @var string
     *
     * @ORM\Column(name="current_state", type="smallint", length=255)
     */
    private $currentState;

    /**
     * @var string
     *
     * @ORM\Column(name="bandwidth", type="integer")
     */
    private $bandwidth;

    /**
     * @var string
     *
     * @ORM\Column(name="last_renovated", type="datetime")
     */
    private $lastRenovated;

    /**
     * @var string
     *
     * @ORM\Column(name="renovate_data", type="string", nullable=true, length=255)
     */
    private $renovateData;

    /**
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @ORM\Column(name="accounting_price", type="integer")
     */
    private $accountingPrice;

    /**
     * @ORM\Column(name="actual_price", type="integer")
     */
    private $actualPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="over_size", type="integer")
     */
    private $overSize;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    protected $sketch;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="mould")
     */
    private $product;

    //TODO
    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="mould", cascade={"persist"})
     * @ORM\JoinTable(name="mould_place")
     */
    private $placeWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment", inversedBy="mould")
     */
    private $equipment;

    //TODO
    /**
     * @ORM\ManyToOne(targetEntity="PurposeList", inversedBy="mould", cascade={"persist"})
     */
    private $purposeList;

    /**
     * @var integer
     * @ORM\Column(name="general_count", type="integer")
     */
    private $generalCount;
    
    //relation
//    private $currentOrder;

    //relation
//    private $chronology for SHOW ;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var datetime $updated
     *
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
     * Set lastRenovated
     *
     * @param \DateTime $lastRenovated
     * @return Mould
     */
    public function setLastRenovated($lastRenovated)
    {
        $this->lastRenovated = $lastRenovated;

        return $this;
    }

    /**
     * Get lastRenovated
     *
     * @return \DateTime
     */
    public function getLastRenovated()
    {
        return $this->lastRenovated;
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
     * Set image
     *
     * @param \Application\MediaBundle\Entity\Media $image
     * @return Mould
     */
    public function setImage(\Application\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\MediaBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sketch
     *
     * @param \Application\MediaBundle\Entity\Media $sketch
     * @return Mould
     */
    public function setSketch(\Application\MediaBundle\Entity\Media $sketch = null)
    {
        $this->sketch = $sketch;

        return $this;
    }

    /**
     * Get sketch
     *
     * @return \Application\MediaBundle\Entity\Media 
     */
    public function getSketch()
    {
        return $this->sketch;
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
     * Set price
     *
     * @param integer $price
     * @return Mould
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
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
     * Set renovateData
     *
     * @param string $renovateData
     * @return Mould
     */
    public function setRenovateData($renovateData)
    {
        $this->renovateData = $renovateData;

        return $this;
    }

    /**
     * Get renovateData
     *
     * @return string 
     */
    public function getRenovateData()
    {
        return $this->renovateData;
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
}
