<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PartnersList
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"name"},
 *     errorPath="name",
 *     message="This name already exist in partners.")
 */
class PartnersList
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="client", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="RawMaterials", mappedBy="vendors", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $rawMaterials;

    /**
     * @ORM\ManyToMany(targetEntity="SparePart", mappedBy="vendors", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $sparePart;

    /**
     * @ORM\ManyToMany(targetEntity="Tools", mappedBy="vendors", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $tools;

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
     * @return PartnersList
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
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return PartnersList
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
     * Set created
     *
     * @param \DateTime $created
     * @return PartnersList
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return PartnersList
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add rawMaterials
     *
     * @param \MainBundle\Entity\RawMaterials $rawMaterials
     * @return PartnersList
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
     * @return PartnersList
     */
    public function addTool(\MainBundle\Entity\Tools $tools)
    {
        $tools->addVendor($this);
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
     * @return PartnersList
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
