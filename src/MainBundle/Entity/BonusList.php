<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonusList
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BonusList
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
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="bonus", type="integer")
     */
    private $bonus;

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
     * Set position
     *
     * @param string $position
     * @return BonusList
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set bonus
     *
     * @param integer $bonus
     * @return BonusList
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return integer 
     */
    public function getBonus()
    {
        return $this->bonus;
    }
}
