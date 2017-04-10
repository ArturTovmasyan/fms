<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ElPower
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ElPower
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
     * @ORM\Column(name="value", type="string", length=10)
     * @Assert\Regex("/[0-9]/")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=50, nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="elPowers", cascade={"persist"})
     */
    protected $equipment;

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
     * Set value
     *
     * @param string $value
     * @return ElPower
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return ElPower
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return ElPower
     */
    public function setEquipment(\MainBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \MainBundle\Entity\Equipment 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)($this->value) ? (string)($this->value) : '';
    }
}
