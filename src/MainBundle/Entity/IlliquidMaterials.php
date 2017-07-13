<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\MultipleFileInterface;
use JMS\Serializer\Annotation\Groups;

/**
 * IlliquidMaterials
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\IlliquidMaterialsRepository")
 */
class IlliquidMaterials extends RawMaterials implements MultipleFileInterface
{
    /**
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="illiquidMaterials", cascade={"persist", "remove"})
     * @Groups({"files"})
     */
    protected $images;

    /**
     * Add images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     * @return IlliquidMaterials
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
