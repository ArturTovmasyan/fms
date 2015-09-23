<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product
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
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="gost", type="string", length=255, nullable=true)
     */
    private $gost;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="smallint", nullable=true)
     */
    private $size;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_in_warehouse", type="integer")
     */
    private $countInWarehouse;

    /**
     * @var string
     *
     * @ORM\Column(name="product_workshop", type="smallint", nullable=true)
     */
    private $workshop;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_equipment")
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="Mould", inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="product_mould")
     */
    private $mould;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_place")
     */
    private $placeWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="Client", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_client")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    protected $sketch;

    /**
     * @ORM\ManyToOne(targetEntity="PurposeList", inversedBy="product", cascade={"persist"})
     */
    private $purposeList;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Gallery", cascade={"remove","persist"})
     */
    private $certificate;


//relations
//    private $price;

//relations
//    private $operationCard;

//relations
//    private $currentOrder;

    /**
     * @var integer
     * @ORM\Column(name="general_count", type="integer")
     */
    private $generalCount;

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
     * @return Product
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
     * @return Product
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
     * Set gost
     *
     * @param string $gost
     * @return Product
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
     * Set weight
     *
     * @param integer $weight
     * @return Product
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
     * Set size
     *
     * @param integer $size
     * @return Product
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
     * Set created
     *
     * @param \DateTime $created
     * @return Product
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
     * @return Product
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
     * This function is used to get size string name
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
                echo "";
        }

        return $stringSize;
    }

    /**
     * This function is used to get producing workshop string name
     *
     * @return null|string
     */
    public function getStringWorkshop()
    {

        $stringWorkshop = null;

        switch($this->workshop) {
            case 0:
                $stringWorkshop = "Ռեզինե";
                break;
            case 1:
                $stringWorkshop = "Մեխանիկական";
                break;
            case 2:
                $stringWorkshop = "Համատեղ";
                break;

            default:
                $stringWorkshop= "";
        }

        return $stringWorkshop;
    }


    /**
     * Set purposeList
     *
     * @param \MainBundle\Entity\PurposeList $purposeList
     * @return Product
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
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
    }

    /**
     * Set workshop
     *
     * @param string $workshop
     * @return Product
     */
    public function setWorkshop($workshop)
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop
     *
     * @return string 
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }

    /**
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return Product
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
     * Add mould
     *
     * @param \MainBundle\Entity\Mould $mould
     * @return Product
     */
    public function addMould(\MainBundle\Entity\Mould $mould)
    {
        $this->mould[] = $mould;

        return $this;
    }

    /**
     * Remove mould
     *
     * @param \MainBundle\Entity\Mould $mould
     */
    public function removeMould(\MainBundle\Entity\Mould $mould)
    {
        $this->mould->removeElement($mould);
    }

    /**
     * Get mould
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMould()
    {
        return $this->mould;
    }

    /**
     * Set image
     *
     * @param \Application\MediaBundle\Entity\Media $image
     * @return Product
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
     * @return Product
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
     * Constructor
     */
    public function __construct()
    {
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mould = new \Doctrine\Common\Collections\ArrayCollection();
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->client = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add client
     *
     * @param \MainBundle\Entity\Client $client
     * @return Product
     */
    public function addClient(\MainBundle\Entity\Client $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \MainBundle\Entity\Client $client
     */
    public function removeClient(\MainBundle\Entity\Client $client)
    {
        $this->client->removeElement($client);
    }

    /**
     * Get client
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set generalCount
     *
     * @param integer $generalCount
     * @return Product
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
     * @return Product
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
     * Set countInWarehouse
     *
     * @param integer $countInWarehouse
     * @return Product
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
     * Set certificate
     *
     * @param \Application\MediaBundle\Entity\Gallery $certificate
     * @return Product
     */
    public function setCertificate(\Application\MediaBundle\Entity\Gallery $certificate = null)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get certificate
     *
     * @return \Application\MediaBundle\Entity\Gallery 
     */
    public function getCertificate()
    {
        return $this->certificate;
    }
}
