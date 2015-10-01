<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalariesType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SalariesType
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
     * @ORM\Column(name="hour_salary", type="integer")
     */
    private $hourSalary;

    /**
     * @var integer
     *
     * @ORM\Column(name="day_salary", type="integer")
     */
    private $daySalary;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessionCategory", inversedBy="salariesType", cascade={"persist"})
     */
    protected $professionCategory;

    /**
     * @ORM\ManyToOne(targetEntity="Professions", inversedBy="salariesType", cascade={"persist"})
     */
    protected $profession;

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->professionCategory) ? (string)$this->professionCategory : '';
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
     * Set rate
     *
     * @param integer $rate
     * @return SalariesType
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set professionCategory
     *
     * @param \MainBundle\Entity\ProfessionCategory $professionCategory
     * @return SalariesType
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
     * @return SalariesType
     */
    public function setProfession(\MainBundle\Entity\Professions $profession = null)
    {
        $this->profession = $profession;

        $profession->addSalariesType($this);
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
     * Set hourSalary
     *
     * @param integer $hourSalary
     * @return SalariesType
     */
    public function setHourSalary($hourSalary)
    {
        $this->hourSalary = $hourSalary;

        return $this;
    }

    /**
     * Get hourSalary
     *
     * @return integer 
     */
    public function getHourSalary()
    {
        return $this->hourSalary;
    }

    /**
     * Set daySalary
     *
     * @param integer $daySalary
     * @return SalariesType
     */
    public function setDaySalary($daySalary)
    {
        $this->daySalary = $daySalary;

        return $this;
    }

    /**
     * Get daySalary
     *
     * @return integer 
     */
    public function getDaySalary()
    {
        return $this->daySalary;
    }
}
