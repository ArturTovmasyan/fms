<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductRawExpense
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="create_raw_expense", columns={"raw_materials_id", "product_id"})})
 * @ORM\Entity()
 * @UniqueEntity(
 *     fields={"rawMaterials", "product"},
 *     errorPath="rawMaterials",
 *     message="Dublicate raw materials"
 * )
 */
class ProductRawExpense
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
     * @ORM\ManyToOne(targetEntity="RawMaterials", inversedBy="productRawExpense", cascade={"persist"})
     */
    protected $rawMaterials;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productRawExpense", cascade={"persist"})
     */
    protected $product;

    /**
     * @ORM\Column(name="count", type="integer", nullable=true)
     */
    private $count = 0;

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
     * @return string
     */
    function __toString()
    {
        return ((string)$this->id) ? (string)$this->id : '';
    }

    /**
     * @return mixed
     */
    public function getProductRawPrice()
    {
        $rawActualCost = $this->getRawMaterials() ? $this->getRawMaterials()->getActualCost() : 0;

        $rawPrice = $this->count * $rawActualCost;

        return $rawPrice;
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
     * Set count
     *
     * @param integer $count
     * @return ProductRawExpense
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ProductRawExpense
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
     * @return ProductRawExpense
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
     * @return ProductRawExpense
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
     * Set rawMaterials
     *
     * @param \MainBundle\Entity\RawMaterials $rawMaterials
     * @return ProductRawExpense
     */
    public function setRawMaterials(\MainBundle\Entity\RawMaterials $rawMaterials = null)
    {
        $this->rawMaterials = $rawMaterials;

        return $this;
    }

    /**
     * Get rawMaterials
     *
     * @return \MainBundle\Entity\RawMaterials 
     */
    public function getRawMaterials()
    {
        return $this->rawMaterials;
    }

    /**
     * @return int|string
     */
    public function getRawMaterialPrice()
    {
        $price = 0;

        $rawMaterial = $this->getRawMaterials();

        if($rawMaterial) {
            $price = $rawMaterial->getActualCost();
        }

        return $price;

    }
}
