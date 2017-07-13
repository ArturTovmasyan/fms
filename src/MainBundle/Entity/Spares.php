<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Spares
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Spares
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

//    /**
//     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="spares", cascade={"persist"})
//     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", onDelete="SET NULL")
//     */
//    private $equipment;

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
     * @return Spares
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

//    /**
//     * Set equipment
//     *
//     * @param \MainBundle\Entity\Equipment $equipment
//     * @return Spares
//     */
//    public function setEquipment(\MainBundle\Entity\Equipment $equipment = null)
//    {
//        $this->equipment = $equipment;
//
//        return $this;
//    }
//
//    /**
//     * Get equipment
//     *
//     * @return \MainBundle\Entity\Equipment
//     */
//    public function getEquipment()
//    {
//        return $this->equipment;
//    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Spares
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
     * @return Spares
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
}
