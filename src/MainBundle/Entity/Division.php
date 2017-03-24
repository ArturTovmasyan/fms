<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Division
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Division
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
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="subordination", type="string", length=50, nullable=true)
     */
    private $subordination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     *
     * @ORM\Column(name="orders", type="string", nullable=true)
     */
    private $orders;

    /**
     *
     * @ORM\Column(name="head_position", type="string", nullable=true)
     */
    private $headPosition;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

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
     * @return Division
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
     * Set subordination
     *
     * @param string $subordination
     * @return Division
     */
    public function setSubordination($subordination)
    {
        $this->subordination = $subordination;

        return $this;
    }

    /**
     * Get subordination
     *
     * @return string 
     */
    public function getSubordination()
    {
        return $this->subordination;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Division
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
     * Set orders
     *
     * @param string $orders
     * @return Division
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return string 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set headPosition
     *
     * @param string $headPosition
     * @return Division
     */
    public function setHeadPosition($headPosition)
    {
        $this->headPosition = $headPosition;

        return $this;
    }

    /**
     * Get headPosition
     *
     * @return string 
     */
    public function getHeadPosition()
    {
        return $this->headPosition;
    }

    /**
     * Set type
     *
     * @param \MainBundle\Entity\DivisionType $type
     * @return Division
     */
    public function setType(\MainBundle\Entity\DivisionType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \MainBundle\Entity\DivisionType 
     */
    public function getType()
    {
        return $this->type;
    }
}
