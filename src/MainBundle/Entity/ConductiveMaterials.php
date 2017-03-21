<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\MultipleFileInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConductiveMaterials
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ConductiveMaterials extends RawMaterials implements MultipleFileInterface
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
     * @ORM\OneToMany(targetEntity="RawMaterialImages", mappedBy="conductiveMaterials", cascade={"persist", "remove"})
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

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
