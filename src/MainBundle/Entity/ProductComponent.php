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
     * @ORM\OneToMany(targetEntity="RouteCard", mappedBy="productComponent", cascade={"persist", "remove"})
     */
    protected $routeCard;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productComponent", cascade={"persist"})
     */
    protected $product;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

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
     * Set product
     *
     * @param \MainBundle\Entity\Product $product
     * @return ProductComponent
     */
    public function setProduct(\MainBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MainBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     * @return ProductComponent
     */
    public function addRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $routeCard->setProductComponent($this);
        $this->routeCard[] = $routeCard;

        return $this;
    }

    /**
     * Remove routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     */
    public function removeRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $this->routeCard->removeElement($routeCard);
    }

    /**
     * Get routeCard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRouteCard()
    {
        return $this->routeCard;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routeCard = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
