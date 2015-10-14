<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductComponent
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductComponent
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
     * @ORM\OneToMany(targetEntity="ProductRouteCard", mappedBy="productComponent", cascade={"persist", "remove"})
     */
    protected $productRouteCard;

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
     * Constructor
     */
    public function __construct()
    {
        $this->productRouteCard = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->name) ? (string)$this->name : '';
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
     * @return ProductComponent
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
     * Set created
     *
     * @param \DateTime $created
     * @return ProductComponent
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
     * @return ProductComponent
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
     * Add productRouteCard
     *
     * @param \MainBundle\Entity\ProductRouteCard $productRouteCard
     * @return ProductComponent
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
