<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"name"}, errorPath="name", message="This name is already exist")
 */
class Product
{
//* @Assert\Callback(methods={"validate"})

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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="gost", type="string", length=50, nullable=true)
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
     * @ORM\Column(name="count_in_warehouse", type="integer", nullable=true)
     */
    private $countInWarehouse;

    /**
     * @ORM\ManyToOne(targetEntity="ProductWorkshop")
     * @ORM\JoinColumn(name="product_workshop_id", referencedColumnName="id")
     */
    private $workshop;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_equipment")
     */
    protected $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="Mould", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_mould")
     */
    protected $mould;

    /**
     * @ORM\ManyToMany(targetEntity="PlaceWarehouse", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_place")
     */
    protected $placeWarehouse;

    /**
     * @ORM\ManyToMany(targetEntity="PartnersList", inversedBy="product", cascade={"persist"})
     * @ORM\JoinTable(name="product_client")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="PurposeList", inversedBy="product", cascade={"persist"})
     */
    protected $purposeList;

    /**
     * @ORM\OneToMany(targetEntity="ProductRawExpense", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $productRawExpense;

    /**
     * @ORM\OneToMany(targetEntity="ProductComponent", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $productComponent;

    //relations
    //private $price;

    //relations
    //private $currentOrder;

    /**
     * @var integer
     * @ORM\Column(name="general_count", type="integer", nullable=true)
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
     * This function is used to get product raw expense sum
     *
     * @return int
     */
    public function getSumRawExpense()
    {
        //get product raw expense
        $productRawExpense = $this->getProductRawExpense();

        //set sum expense
        $sumExpense = 0;

        foreach($productRawExpense as $productExpense)
        {
            //get product raw price
            $rawPrice = $productExpense->getProductRawPrice();

            //sum price
            $sumExpense += $rawPrice;
        }
        return $sumExpense;
    }


    /**
     * This function is used to get product route card sum
     *
     * @return int
     */
    public function getSumRouteCard()
    {
       $components = $this->getProductComponent();
       $sumRouteCard = 0;

       if(count($components) > 0) {
           foreach ($components as $component)
           {
               $routeCards = $component->getRouteCard();

               if(count($routeCards) > 0) {
                   foreach ($routeCards as $routeCard)
                   {
                       $sumRouteCard += $routeCard->getSum();
                   }
               }
           }
       }

        return $sumRouteCard;
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
     * Constructor
     */
    public function __construct()
    {
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mould = new \Doctrine\Common\Collections\ArrayCollection();
        $this->placeWarehouse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->client = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productComponent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add PartnersList
     *
     * @param \MainBundle\Entity\PartnersList $client
     * @return Product
     */
    public function addClient(\MainBundle\Entity\PartnersList $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove PartnersList
     *
     * @param \MainBundle\Entity\PartnersList $client
     */
    public function removeClient(\MainBundle\Entity\PartnersList $client)
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
     * Add productRawExpense
     *
     * @param \MainBundle\Entity\ProductRawExpense $productRawExpense
     * @return Product
     */
    public function addProductRawExpense(\MainBundle\Entity\ProductRawExpense $productRawExpense)
    {
        $productRawExpense->setProduct($this);
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

//    /**
//     * @param ExecutionContext $context
//     */
//    public function validate(ExecutionContext $context)
//    {
//        //get components
//        $components = $this->getProductComponent();
//
//        //if components exist
//        if($components) {
//
//            foreach($components as $component)
//            {
//                //get route card
//                $routeCards = $component->getProductRouteCard();
//
//                //if route cards exist
//                if($routeCards) {
//
//                    foreach($routeCards as $routeCard) {
//
//                        //get profession
//                        $profession = $routeCard->getProfession();
//
//                        //get profession category
//                        $professionCategory = $routeCard->getProfessionCategory();
//
//                        $name = $professionCategory->getName();
//
//                        //get all salaries type by profession indexBy category id
//                        $salariesTypeArray = $profession->getSalariesType();
//
//                        //get salaries type by profession category id
//                        $salariesType = $salariesTypeArray[$professionCategory->getId()];
//
//                        //check if salariesType exist
//                        if (!$salariesType) {
//                            $context->addViolationAt(
//                                'productRouteCard',
//                                'This profession by category not exist "%category%"',
//                                array('%category%', $name),
//                                null
//                            );
//                        }
//                    }
//                }
//            }
//        }
//    }


    /**
     * Add productComponent
     *
     * @param \MainBundle\Entity\ProductComponent $productComponent
     * @return Product
     */
    public function addProductComponent(\MainBundle\Entity\ProductComponent $productComponent)
    {
        $productComponent->setProduct($this);
        $this->productComponent[] = $productComponent;

        return $this;
    }

    /**
     * Remove productComponent
     *
     * @param \MainBundle\Entity\ProductComponent $productComponent
     */
    public function removeProductComponent(\MainBundle\Entity\ProductComponent $productComponent)
    {
        $this->productComponent->removeElement($productComponent);
    }

    /**
     * Get productComponent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductComponent()
    {
        return $this->productComponent;
    }
}
