<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class RouteCard
 * @package MainBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="route_card",uniqueConstraints={@UniqueConstraint(name="unique_route_card_idx", columns=
 *                  {"profession_id", "profession_category", "product_component_id"})})
 *
 * @UniqueEntity(fields={"profession", "professionCategory", "productComponent"}, errorPath="profession",
 *                  message="Route card by this profession and category already exist for this component")
 */
class RouteCard
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
     * @Assert\NotBlank()
     * @ORM\Column(name="operation", type="string", length=50)
     */
    private $operation;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="operationCode", type="string", length=50)
     */
    private $operationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="dependency", type="string", length=50, nullable=true)
     */
    private $dependency;

    /**
     * @ORM\ManyToOne(targetEntity="Professions", inversedBy="routeCard", cascade={"persist"})
     */
    protected $profession;

    /**
     * @var integer
     *
     * @ORM\Column(name="tariff", type="integer")
     */
    private $tariff;

    /**
     * @var string
     *
     * @ORM\Column(name="profession_category", type="string", length=50)
     */
    private $professionCategory;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="jobTime", type="string", length=50, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]\d*[\.]{0,1}(\d+)?$/", message="This value must contain only number and decimal")
     */
    private $jobTime;

    /**
     * @var string
     *
     * @ORM\Column(name="sum", type="integer")
     */
    private $sum = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="specificPercent", type="integer", nullable=true)
     */
    private $specificPercent = 100;

    /**
     * @ORM\ManyToOne(targetEntity="ProductComponent", inversedBy="routeCard", cascade={"persist"})
     */
    protected $productComponent;

    /**
     * @ORM\ManyToOne(targetEntity="Mould", inversedBy="routeCard", cascade={"persist"})
     * @ORM\JoinColumn(name="mould_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $mould;

    /**
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="routeCard", cascade={"persist"})
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $equipment;

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
     * @param $operation
     * @return $this
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
     * @param $operationCode
     * @return $this
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
     * @param $dependency
     * @return $this
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
     * @param $jobTime
     * @return $this
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
     * @param $specificPercent
     * @return $this
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
     * @param ProductComponent|null $productComponent
     * @return $this
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
     * @param Mould|null $mould
     * @return $this
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
     * Set equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return RouteCard
     */
    public function setEquipment(\MainBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \MainBundle\Entity\Equipment 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set profession
     *
     * @param \MainBundle\Entity\Professions $profession
     * @return RouteCard
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


    /**
     * Set sum
     *
     * @param string $sum
     * @return RouteCard
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string 
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set professionCategory
     *
     * @param string $professionCategory
     * @return RouteCard
     */
    public function setProfessionCategory($professionCategory)
    {
        $this->professionCategory = $professionCategory;

        return $this;
    }

    /**
     * Get professionCategory
     *
     * @return string 
     */
    public function getProfessionCategory()
    {
        return $this->professionCategory;
    }

    /**
     * Set tariff
     *
     * @param integer $tariff
     * @return RouteCard
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * Get tariff
     *
     * @return integer 
     */
    public function getTariff()
    {
        return $this->tariff;
    }
}
