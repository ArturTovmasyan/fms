<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Equipment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\EquipmentRepository")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="this code is already exist")
 */
class Equipment
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
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min = 3, max=3)
     * @Assert\Regex("/[0-9]/")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="over_size", type="string", length=20, nullable=true)
     */
    private $overSize;

    /**
     *
     * @ORM\Column(name="purchase_date", type="datetime")
     */
    private $purchaseDate;

    /**
     * @ORM\ManyToOne(targetEntity="Workshop")
     */
    private $workshop;

    /**
     * @ORM\ManyToOne(targetEntity="WorkshopType")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="equipment", fetch="EXTRA_LAZY")
     */
    protected $product;

    /**
     * @ORM\ManyToMany(targetEntity="Mould", mappedBy="equipment", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="equipment_mould")
     */
    private $mould;

    /**
     * @ORM\ManyToMany(targetEntity="Personnel", inversedBy="equipment", cascade={"persist"})
     * @ORM\JoinTable(name="equipment_personnel")
     */
    protected $responsiblePersons;

    /**
     * @ORM\ManyToMany(targetEntity="SparePart", inversedBy="equipment", cascade={"persist"})
     * @ORM\JoinTable(name="equipment_spare_part")
     */
    protected $sparePart;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Deployment")
     */
    private $deployment;

    /**
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @ORM\Column(name="el_power", type="integer")
     */
    private $elPower;

    /**
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(name="carrying_price", type="integer")
     */
    private $carryingPrice;

    /**
     * @ORM\Column(name="factual_price", type="integer")
     */
    private $factualPrice;

    /**
     * @ORM\Column(name="inspection_period", type="integer")
     */
    private $inspectionPeriod;

    /**
     * @ORM\Column(name="repair_job", type="string", nullable=true)
     */
    private $repairJob;

    /**
     * @ORM\Column(name="inspection_next_date", type="datetime")
     */
    private $inspectionNextDate;

    /**
     * @ORM\OneToMany(targetEntity="Spares", mappedBy="equipment")
     */
    protected $spares;

    /**
     * @ORM\OneToOne(targetEntity="EquipmentReport", cascade={"persist", "remove"})
     */
    protected $report;

    /**
     * @ORM\OneToMany(targetEntity="EquipmentImage", mappedBy="equipment", cascade={"persist", "remove"})
     */
    protected $images;

//    /**
//     * @ORM\OneToMany(targetEntity="ProductRouteCard", mappedBy="equipment", cascade={"persist"})
//     */
//    protected $productRouteCard;

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
        return ($this->name) ? $this->name : '';
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
     * @return bool|mixed
     */
    public function getEquipmentImages()
    {
        // get images
        $files = $this->getImages();

        // check images
        if($files){

            return $files;
        }

        return null;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Equipment
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
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mould = new \Doctrine\Common\Collections\ArrayCollection();
        $this->responsiblePersons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->spares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return Equipment
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
     * Add mould
     *
     * @param \MainBundle\Entity\Mould $mould
     * @return Equipment
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
     * Set description
     *
     * @param string $description
     * @return Equipment
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
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     * @return Equipment
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime 
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Add responsiblePersons
     *
     * @param \MainBundle\Entity\Personnel $responsiblePersons
     * @return Equipment
     */
    public function addResponsiblePerson(\MainBundle\Entity\Personnel $responsiblePersons)
    {
        $this->responsiblePersons[] = $responsiblePersons;

        return $this;
    }

    /**
     * Remove responsiblePersons
     *
     * @param \MainBundle\Entity\Personnel $responsiblePersons
     */
    public function removeResponsiblePerson(\MainBundle\Entity\Personnel $responsiblePersons)
    {
        $this->responsiblePersons->removeElement($responsiblePersons);
    }

    /**
     * Get responsiblePersons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponsiblePersons()
    {
        return $this->responsiblePersons;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Equipment
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set elPower
     *
     * @param integer $elPower
     * @return Equipment
     */
    public function setElPower($elPower)
    {
        $this->elPower = $elPower;

        return $this;
    }

    /**
     * Get elPower
     *
     * @return integer 
     */
    public function getElPower()
    {
        return $this->elPower;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Equipment
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
     * Set code
     *
     * @param integer $code
     * @return Equipment
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
     * Set carryingPrice
     *
     * @param integer $carryingPrice
     * @return Equipment
     */
    public function setCarryingPrice($carryingPrice)
    {
        $this->carryingPrice = $carryingPrice;

        return $this;
    }

    /**
     * Get carryingPrice
     *
     * @return integer 
     */
    public function getCarryingPrice()
    {
        return $this->carryingPrice;
    }

    /**
     * Set factualPrice
     *
     * @param integer $factualPrice
     * @return Equipment
     */
    public function setFactualPrice($factualPrice)
    {
        $this->factualPrice = $factualPrice;

        return $this;
    }

    /**
     * Get factualPrice
     *
     * @return integer 
     */
    public function getFactualPrice()
    {
        return $this->factualPrice;
    }

    /**
     * Set inspectionNextDate
     *
     * @param \DateTime $inspectionNextDate
     * @return Equipment
     */
    public function setInspectionNextDate($inspectionNextDate)
    {
        $this->inspectionNextDate = $inspectionNextDate;

        return $this;
    }

    /**
     * Get inspectionNextDate
     *
     * @return \DateTime 
     */
    public function getInspectionNextDate()
    {
        return $this->inspectionNextDate;
    }

    /**
     * Add spares
     *
     * @param \MainBundle\Entity\Spares $spares
     * @return Equipment
     */
    public function addSpare(\MainBundle\Entity\Spares $spares)
    {
        $this->spares[] = $spares;

        return $this;
    }

    /**
     * Remove spares
     *
     * @param \MainBundle\Entity\Spares $spares
     */
    public function removeSpare(\MainBundle\Entity\Spares $spares)
    {
        $this->spares->removeElement($spares);
    }

    /**
     * Get spares
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpares()
    {
        return $this->spares;
    }

    /**
     * Set inspectionPeriod
     *
     * @param integer $inspectionPeriod
     * @return Equipment
     */
    public function setInspectionPeriod($inspectionPeriod)
    {
        //set date
        $date =$this->created ? $this->created : new \DateTime();
        $this->setInspectionNextDate(date_add($date, date_interval_create_from_date_string($inspectionPeriod . 'day')));

        $this->inspectionPeriod = $inspectionPeriod;

        return $this;
    }

    /**
     * Get inspectionPeriod
     *
     * @return integer 
     */
    public function getInspectionPeriod()
    {
        return $this->inspectionPeriod;
    }

    /**
     * This function is used to get equipment workshop string name
     *
     * @return null|string
     */
    public  function getStringState()
    {
        $stringState = null;

        switch($this->state) {
            case 0:
                $stringState = "Սարքին` բարվոք վիճակում";
                break;
            case 1:
                $stringState = "Աշխատող` վերանորոգման ենթակա";
                break;
            case 2:
                $stringState = "Չաշխատող` վերանորոգման ենթակա";
                break;
            case 3:
                $stringState = "Անհուսալի";
                break;
            default:
                $stringState= "";
        }

        return $stringState;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Equipment
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
     * @return Equipment
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
     * Set deployment
     *
     * @param \MainBundle\Entity\Deployment $deployment
     * @return Equipment
     */
    public function setDeployment(\MainBundle\Entity\Deployment $deployment = null)
    {
        $this->deployment = $deployment;

        return $this;
    }

    /**
     * Get deployment
     *
     * @return \MainBundle\Entity\Deployment 
     */
    public function getDeployment()
    {
        return $this->deployment;
    }

    /**
     * @return array
     */
    public function  getEqMultipleFile()
    {
        // check images and return array
        if($this->images){

            return $this->images->toArray();
        }
        return array();
    }

    /**
     * @param $multipleFile
     */
    public function  setEqMultipleFile($multipleFile)
    {
        // check added images
        if(count($multipleFile) > 0){

            $this->images = new ArrayCollection($multipleFile);
        }
    }

    /**
     * Add images
     *
     * @param \MainBundle\Entity\EquipmentImage $images
     * @return Equipment
     */
    public function addImage(\MainBundle\Entity\EquipmentImage $images)
    {
        $this->images[] = $images;
        $images->setEquipment($this);

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MainBundle\Entity\EquipmentImage $images
     */
    public function removeImage(\MainBundle\Entity\EquipmentImage $images)
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
     * Set repairJob
     *
     * @param string $repairJob
     * @return Equipment
     */
    public function setRepairJob($repairJob)
    {
        $this->repairJob = $repairJob;

        return $this;
    }

    /**
     * Get repairJob
     *
     * @return string 
     */
    public function getRepairJob()
    {
        return $this->repairJob;
    }

    /**
     * Set workshop
     *
     * @param \MainBundle\Entity\Workshop $workshop
     * @return Equipment
     */
    public function setWorkshop(\MainBundle\Entity\Workshop $workshop = null)
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop
     *
     * @return \MainBundle\Entity\Workshop
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }

    /**
     * Set type
     *
     * @param \MainBundle\Entity\WorkshopType $type
     * @return Equipment
     */
    public function setType(\MainBundle\Entity\WorkshopType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \MainBundle\Entity\WorkshopType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set report
     *
     * @param \MainBundle\Entity\EquipmentReport $report
     * @return Equipment
     */
    public function setReport(\MainBundle\Entity\EquipmentReport $report = null)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \MainBundle\Entity\EquipmentReport 
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set overSize
     *
     * @param integer $overSize
     * @return Equipment
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
     * Add sparePart
     *
     * @param \MainBundle\Entity\SparePart $sparePart
     * @return Equipment
     */
    public function addSparePart(\MainBundle\Entity\SparePart $sparePart)
    {
        $this->sparePart[] = $sparePart;

        return $this;
    }

    /**
     * Remove sparePart
     *
     * @param \MainBundle\Entity\SparePart $sparePart
     */
    public function removeSparePart(\MainBundle\Entity\SparePart $sparePart)
    {
        $this->sparePart->removeElement($sparePart);
    }

    /**
     * Get sparePart
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSparePart()
    {
        return $this->sparePart;
    }
}
