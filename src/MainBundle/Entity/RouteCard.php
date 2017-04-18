<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RouteCard
 * @package MainBundle\Entity
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\Column(name="operation", type="string", length=50, nullable=true)
     */
    private $operation;

    /**
     * @var string
     *
     * @ORM\Column(name="operationCode", type="string", length=50, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="jobTime", type="string", length=50, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]\d*[\.]{0,1}(\d+)?$/", message="This value must contain only number and decimal")
     */
    private $jobTime;

    /**
     * @var string
     *
     * @ORM\Column(name="sum", type="integer", nullable=true)
     */
    private $sum;

    /**
     * @var integer
     *
     * @ORM\Column(name="specificPercent", type="integer")
     */
    private $specificPercent = 100;

    /**
     * @ORM\ManyToOne(targetEntity="ProductComponent", inversedBy="routeCard", cascade={"persist", "remove"})
     */
    protected $productComponent;

    /**
     * @ORM\ManyToOne(targetEntity="Mould", inversedBy="routeCard", cascade={"persist"})
     */
    protected $mould;

    /**
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="routeCard", cascade={"persist"})
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

//    /**
//     * @return mixed
//     */
//    public function getProductRouteCardPrice()
//    {
//        $tariffs = $this->getProfession()->getTariff();
//
//        if($tariffs) {
//            foreach ($tariffs as $tariff)
//            {
//                $catId = $tariff->getProfessionCategory()->getId();
//
//                if($catId) {
//                }
//            }
//        }
//        return $rawPrice;
//    }

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
}
