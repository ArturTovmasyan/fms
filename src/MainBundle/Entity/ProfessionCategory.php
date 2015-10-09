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
     * @ORM\OneToMany(targetEntity="SalariesType", mappedBy="professionCategory", cascade={"persist"})
     */
    protected $salariesType;

    /**
     * @ORM\OneToMany(targetEntity="ProductRouteCard", mappedBy="professionCategory", cascade={"persist"})
     */
    protected $productRouteCard;

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
     * Constructor
     */
    public function __construct()
    {
        $this->salariesType = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add salariesType
     *
     * @param \MainBundle\Entity\SalariesType $salariesType
     * @return ProfessionCategory
     */
    public function addSalariesType(\MainBundle\Entity\SalariesType $salariesType)
    {
        $this->salariesType[] = $salariesType;

        return $this;
    }

    /**
     * Remove salariesType
     *
     * @param \MainBundle\Entity\SalariesType $salariesType
     */
    public function removeSalariesType(\MainBundle\Entity\SalariesType $salariesType)
    {
        $this->salariesType->removeElement($salariesType);
    }

    /**
     * Get salariesType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalariesType()
    {
        return $this->salariesType;
    }

    /**
     * Add productRouteCard
     *
     * @param \MainBundle\Entity\ProductRouteCard $productRouteCard
     * @return ProfessionCategory
     */
    public function addProductRouteCard(\MainBundle\Entity\ProductRouteCard $productRouteCard)
    {
        $this->productRouteCard[] = $productRouteCard;

        return $this;
    }

    /**
     * Remove productRouteCard
     *
     * @param \MainBundle\Entity\ProductRouteCard $productRouteCard
     */
    public function removeProductRouteCard(\MainBundle\Entity\ProductRouteCard $productRouteCard)
    {
        $this->productRouteCard->removeElement($productRouteCard);
    }

    /**
     * Get productRouteCard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductRouteCard()
    {
        return $this->productRouteCard;
    }
}
