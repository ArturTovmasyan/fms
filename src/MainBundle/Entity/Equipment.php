<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Equipment
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\Column(name="code", type="integer", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 3)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     *
     * @ORM\Column(name="purchase_date", type="datetime")
     */
    private $purchaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="exploiter_workshop", type="smallint", nullable=true)
     */
    private $workshop;

    //TODO
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="equipment")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="Mould", mappedBy="equipment")
     */
    private $mould;

    /**
     * @ORM\ManyToMany(targetEntity="Personnel", inversedBy="equipment", cascade={"persist"})
     * @ORM\JoinTable(name="equipment_personnel")
     */
    private $responsiblePersons;

    /**
     * @var string
     *
     * @ORM\Column(name="deployment", type="string", length=255)
     */
    private $deployment;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Media", cascade={"remove","persist"})
     */
    protected $image;

    /**
     * @ORM\Column(name="state", type="smallint", length=255)
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
     * @ORM\Column(name="inspection_next_date", type="datetime")
     */
    private $inspectionNextDate;

    /**
     * @ORM\OneToMany(targetEntity="Spares", mappedBy="equipment")
     */
    private $spares;

    /**
     * @ORM\ManyToOne(targetEntity="Application\MediaBundle\Entity\Gallery", cascade={"remove","persist"})
     */
    protected $chronologyFile;

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

    // relations with ORDER
//    private $repairs;

    //relation
//    private $currentOrder;

    //relation
//    private $chronology for SHOW ;

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
     * Set workshop
     *
     * @param integer $workshop
     * @return Equipment
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
     * Set deployment
     *
     * @param string $deployment
     * @return Equipment
     */
    public function setDeployment($deployment)
    {
        $this->deployment = $deployment;

        return $this;
    }

    /**
     * Get deployment
     *
     * @return string 
     */
    public function getDeployment()
    {
        return $this->deployment;
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
     * Set image
     *
     * @param \Application\MediaBundle\Entity\Media $image
     * @return Equipment
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
     * Set inspectionPeriod
     *
     * @param integer $inspectionPeriod
     * @return Equipment
     */
    public function setInspectionPeriod($inspectionPeriod)
    {
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
    public  function getStringWorkshop()
    {
        $stringWorkshop = null;

        switch($this->workshop) {
            case 0:
                $stringWorkshop = "Ռետինատեխնիկական";
                break;
            case 1:
                $stringWorkshop = "Մետաղամշակման";
                break;
            case 2:
                $stringWorkshop = "Լաբորատորիա";
                break;
            case 3:
                $stringWorkshop = "Այլ";
                break;
            default:
                $stringWorkshop= "";
        }

        return $stringWorkshop;
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
     * This function is used to get equipment deployment string name
     *
     * @return null|string
     */
    public  function getStringDeployment()
    {
        $stringDeployment = null;

        switch($this->deployment) {
            case 0:
                $stringDeployment = "BANGLADESH";
                break;
            case 1:
                $stringDeployment = "KVARTAL";
                break;
            case 2:
                $stringDeployment = "CHEREMUSHKA";
                break;
            case 3:
                $stringDeployment = "ERORDMAS";
                break;
            default:
                $stringDeployment= "";
        }

        return $stringDeployment;
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
     * Set chronologyFile
     *
     * @param \Application\MediaBundle\Entity\Gallery $chronologyFile
     * @return Equipment
     */
    public function setChronologyFile(\Application\MediaBundle\Entity\Gallery $chronologyFile = null)
    {
        $this->chronologyFile = $chronologyFile;

        return $this;
    }

    /**
     * Get chronologyFile
     *
     * @return \Application\MediaBundle\Entity\Gallery 
     */
    public function getChronologyFile()
    {
        return $this->chronologyFile;
    }

    /**
     * Set technicalFile
     *
     * @param \Application\MediaBundle\Entity\Gallery $technicalFile
     * @return Equipment
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
}
