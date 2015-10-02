<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RubberCategory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RubberCategory
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
     * @ORM\OneToMany(targetEntity="RubberMaterials", mappedBy="category", cascade={"persist"})
     */
    protected $rubberMaterials;

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
     * @return RubberCategory
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
     * @param string $created
     * @return RubberCategory
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return string 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param string $updated
     * @return RubberCategory
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return string 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rawMaterial = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add rubberMaterials
     *
     * @param \MainBundle\Entity\RubberMaterials $rubberMaterials
     * @return RubberCategory
     */
    public function addRubberMaterial(\MainBundle\Entity\RubberMaterials $rubberMaterials)
    {
        $this->rubberMaterials[] = $rubberMaterials;

        return $this;
    }

    /**
     * Remove rubberMaterials
     *
     * @param \MainBundle\Entity\RubberMaterials $rubberMaterials
     */
    public function removeRubberMaterial(\MainBundle\Entity\RubberMaterials $rubberMaterials)
    {
        $this->rubberMaterials->removeElement($rubberMaterials);
    }

    /**
     * Get rubberMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRubberMaterials()
    {
        return $this->rubberMaterials;
    }
}
