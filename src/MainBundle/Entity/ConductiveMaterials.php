<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\MultipleFileInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * ConductiveMaterials
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\ConductiveMaterialsRepository")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="This code is already exist")
 */
class ConductiveMaterials extends RawMaterials implements MultipleFileInterface
{
    /**
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="conductiveMaterials", cascade={"persist", "remove"})
     * @Groups({"files"})
     */
    protected $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="code", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min="6", max="6")
     */
    private $code;

    /**
     * Add images
     *
     * @param \MainBundle\Entity\RawMaterialImages $images
     * @return ConductiveMaterials
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

    /**
     * Set code
     *
     * @param string $code
     * @return ConductiveMaterials
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
