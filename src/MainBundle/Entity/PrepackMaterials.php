<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use MainBundle\Model\MultipleFileInterface;
use JMS\Serializer\Annotation\Groups;


/**
 * PrepackMaterials
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\PrepackMaterialsRepository")
 */
class PrepackMaterials extends RawMaterials implements MultipleFileInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="Product")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment")
     */
    protected $equipment;

    /**
     * @var integer
     *
     * @ORM\Column(name="workshop", type="smallint")
     */
    private $workshop;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="prepackMaterial", cascade={"persist", "remove"})
     * @Groups({"files"})
     */
    protected $images;

    /**
     * @param $workshop
     * @return $this
     */
    public function setWorkshop($workshop)
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop
     *
     * @return integer 
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \MainBundle\Entity\Product $product
     * @return PrepackMaterials
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
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return PrepackMaterials
     */
    public function addEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return PrepackMaterials
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * This function is used to get producing workshop string name
     *
     * @return null|string
     */
    public function getStringWorkshop()
    {
        $stringWorkshop = null;

        switch($this->workshop) {
            case 0:
                $stringWorkshop = "Ռեզինե";
                break;
            case 1:
                $stringWorkshop = "Մեխանիկական";
                break;
            case 2:
                $stringWorkshop = "Համատեղ";
                break;

            default:
                $stringWorkshop= "";
        }

        return $stringWorkshop;
    }

    /**
     * Add images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     * @return PrepackMaterials
     */
    public function addImage(\MainBundle\Entity\RawMaterialImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     */
    public function removeImage(\MainBundle\Entity\RawMaterialImages $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
