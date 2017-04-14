<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tariff
 * @package MainBundle\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="create_tariff", columns={"id", "profession_category_id", "profession_id"})})
 * @ORM\Entity
 */
class Tariff
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
     * @ORM\OneToOne(targetEntity="ProfessionCategory", inversedBy="tariff", cascade={"persist", "remove"})
     */
    protected $professionCategory;

    /**
     * @ORM\ManyToOne(targetEntity="Professions", inversedBy="tariff", cascade={"persist"})
     */
    protected $profession;

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->id ? (string)$this->id : '';
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
     * @param $rate
     * @return $this
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
     * Set hourSalary
     *
     * @param integer $hourSalary
     * @return Tariff
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
     * @return Tariff
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



    /**
     * Set professionCategory
     *
     * @param \MainBundle\Entity\ProfessionCategory $professionCategory
     * @return Tariff
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
     * @return Tariff
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
