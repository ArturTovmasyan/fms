<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PlaceWarehouse
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PlaceWarehouse
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Warehouse", inversedBy="placeWarehouse", cascade={"persist"})
     */
    private $warehouse;

    /**
     * @ORM\ManyToMany(targetEntity="Mould", mappedBy="placeWarehouse", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $mould;

    /**
     * @ORM\ManyToMany(targetEntity="SparePart", mappedBy="placeWarehouse", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $sparePart;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="placeWarehouse", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="RawMaterials", mappedBy="placeWarehouse", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $rawMaterials;

    /**
     * @ORM\ManyToMany(targetEntity="Tools", mappedBy="placeWarehouse", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $tools;

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
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return string
     */
    function __toString()
    {
        return ($this->name) ? $this->name : '';
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
     * @return PlaceWarehouse
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
     * Add mould
     *
     * @param \MainBundle\Entity\Mould $mould
     * @return PlaceWarehouse
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
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return PlaceWarehouse
     */
    public function addProduct(\MainBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \MainBundle\Entity\Product $product
     */
    public function removeProduct(\MainBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set warehouse
     *
     * @param \MainBundle\Entity\Warehouse $warehouse
     * @return PlaceWarehouse
     */
    public function setWarehouse(\MainBundle\Entity\Warehouse $warehouse = null)
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * Get warehouse
     *
     * @return \MainBundle\Entity\Warehouse 
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return PlaceWarehouse
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
     * @return PlaceWarehouse
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
     * Add rawMaterials
     *
     * @param \MainBundle\Entity\RawMaterials $rawMaterials
     * @return PlaceWarehouse
     */
    public function addRawMaterial(\MainBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->rawMaterials[] = $rawMaterials;

        return $this;
    }

    /**
     * Remove rawMaterials
     *
     * @param \MainBundle\Entity\RawMaterials $rawMaterials
     */
    public function removeRawMaterial(\MainBundle\Entity\RawMaterials $rawMaterials)
    {
        $this->rawMaterials->removeElement($rawMaterials);
    }

    /**
     * Get rawMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterials()
    {
        return $this->rawMaterials;
    }

    /**
     * Add tools
     *
     * @param \MainBundle\Entity\Tools $tools
     * @return PlaceWarehouse
     */
    public function addTool(\MainBundle\Entity\Tools $tools)
    {
        $this->tools[] = $tools;

        return $this;
    }

    /**
     * Remove tools
     *
     * @param \MainBundle\Entity\Tools $tools
     */
    public function removeTool(\MainBundle\Entity\Tools $tools)
    {
        $this->tools->removeElement($tools);
    }

    /**
     * Get tools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTools()
    {
        return $this->tools;
    }

    /**
     * Add sparePart
     *
     * @param \MainBundle\Entity\SparePart $sparePart
     * @return PlaceWarehouse
     */
    public function addSparePart(\MainBundle\Entity\SparePart $sparePart)
    {
        $this->sparePart[] = $sparePart;

        return $this;
    }

    /**
     * Remove sparePart
     *
     * @param \MainBundle\Entity\SparePart $sparePart
     */
    public function removeSparePart(\MainBundle\Entity\SparePart $sparePart)
    {
        $this->sparePart->removeElement($sparePart);
    }

    /**
     * Get sparePart
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSparePart()
    {
        return $this->sparePart;
    }
}
