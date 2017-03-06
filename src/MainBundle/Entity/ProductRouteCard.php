<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ProductRouteCard
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ProductRouteCard
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
     * @ORM\Column(name="operation", type="string", length=255)
     */
    private $operation;

    /**
     * @var string
     *
     * @ORM\Column(name="operationCode", type="string", length=255)
     */
    private $operationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="dependency", type="string", length=255)
     */
    private $dependency;

    /**
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="productRouteCard", cascade={"persist"})
     */
    protected $equipment;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessionCategory", inversedBy="productRouteCard", cascade={"persist"})
     */
    protected $professionCategory;

    /**
     * @ORM\ManyToOne(targetEntity="Professions", inversedBy="productRouteCard", cascade={"persist"})
     */
    protected $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="jobTime", type="string", length=255)
     */
    private $jobTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="specificPercent", type="integer")
     */
    private $specificPercent = 100;

    /**
     * @ORM\ManyToOne(targetEntity="ProductComponent", inversedBy="productRouteCard", cascade={"persist"})
     */
    protected $productComponent;

    /**
     * @ORM\ManyToOne(targetEntity="Mould", inversedBy="productRouteCard", cascade={"persist"})
     */
    protected $mould;

      /**
     * @var integer
     *
     * @ORM\Column(name="route_card_price", type="integer")
     */
    protected $routeCardPrice = 0;

    // set profession tariff in productRouteCard list and show
    protected $tariff;

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->id) ? (string)$this->id : '';
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
     * Set operation
     *
     * @param string $operation
     * @return ProductRouteCard
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set tariff
     *
     * @param string $tariff
     * @return ProductRouteCard
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * Get tariff
     *
     * @return string
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param $routeCardPrice
     * @return $this
     */
    public function setRouteCardPrice($routeCardPrice)
    {
        $this->routeCardPrice = $routeCardPrice;

        return $this;
    }

    /**
     * @return int
     */

    public function getRouteCardPrice()
    {
        return $this->routeCardPrice;
    }

    /**
     * Set operationCode
     *
     * @param string $operationCode
     * @return ProductRouteCard
     */
    public function setOperationCode($operationCode)
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * Get operationCode
     *
     * @return string
     */
    public function getOperationCode()
    {
        return $this->operationCode;
    }

    /**
     * Set dependency
     *
     * @param string $dependency
     * @return ProductRouteCard
     */
    public function setDependency($dependency)
    {
        $this->dependency = $dependency;

        return $this;
    }

    /**
     * Get dependency
     *
     * @return string
     */
    public function getDependency()
    {
        return $this->dependency;
    }

    /**
     * Set equipment
     *
     * @param string $equipment
     * @return ProductRouteCard
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return string
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set jobTime
     *
     * @param string $jobTime
     * @return ProductRouteCard
     */
    public function setJobTime($jobTime)
    {
        $this->jobTime = $jobTime;

        return $this;
    }

    /**
     * Get jobTime
     *
     * @return string
     */
    public function getJobTime()
    {
        return $this->jobTime;
    }

    /**
     * Set specificPercent
     *
     * @param integer $specificPercent
     * @return ProductRouteCard
     */
    public function setSpecificPercent($specificPercent)
    {
        $this->specificPercent = $specificPercent;

        return $this;
    }

    /**
     * Get specificPercent
     *
     * @return integer
     */
    public function getSpecificPercent()
    {
        return $this->specificPercent;
    }

    /**
     * Set productComponent
     *
     * @param \MainBundle\Entity\ProductComponent $productComponent
     * @return ProductRouteCard
     */
    public function setProductComponent(\MainBundle\Entity\ProductComponent $productComponent = null)
    {
        $this->productComponent = $productComponent;

        return $this;
    }

    /**
     * Get productComponent
     *
     * @return \MainBundle\Entity\ProductComponent
     */
    public function getProductComponent()
    {
        return $this->productComponent;
    }

    /**
     * Set mould
     *
     * @param \MainBundle\Entity\Mould $mould
     * @return ProductRouteCard
     */
    public function setMould(\MainBundle\Entity\Mould $mould = null)
    {
        $this->mould = $mould;

        return $this;
    }

    /**
     * Get mould
     *
     * @return \MainBundle\Entity\Mould
     */
    public function getMould()
    {
        return $this->mould;
    }

    /**
     * Set professionCategory
     *
     * @param \MainBundle\Entity\ProfessionCategory $professionCategory
     * @return ProductRouteCard
     */
    public function setProfessionCategory(\MainBundle\Entity\ProfessionCategory $professionCategory = null)
    {
        $this->professionCategory = $professionCategory;

        return $this;
    }

    /**
     * Get professionCategory
     *
     * @return \MainBundle\Entity\ProfessionCategory
     */
    public function getProfessionCategory()
    {
        return $this->professionCategory;
    }

    /**
     * Set profession
     *
     * @param \MainBundle\Entity\Professions $profession
     * @return ProductRouteCard
     */
    public function setProfession(\MainBundle\Entity\Professions $profession = null)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return \MainBundle\Entity\Professions
     */
    public function getProfession()
    {
        return $this->profession;
    }
}
