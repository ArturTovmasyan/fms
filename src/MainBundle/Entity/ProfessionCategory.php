<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfessionCategory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProfessionCategory
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
     * @ORM\OneToOne(targetEntity="Tariff", mappedBy="professionCategory", cascade={"persist", "remove"})
     */
    protected $tariff;

//    /**
//     * @ORM\OneToMany(targetEntity="ProductRouteCard", mappedBy="professionCategory", cascade={"persist", "remove"})
//     */
//    protected $productRouteCard;

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
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ProfessionCategory
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
     * Set tariff
     *
     * @param \MainBundle\Entity\Tariff $tariff
     * @return ProfessionCategory
     */
    public function setTariff(\MainBundle\Entity\Tariff $tariff = null)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * Get tariff
     *
     * @return \MainBundle\Entity\Tariff
     */
    public function getTariff()
    {
        return $this->tariff;
    }
}
