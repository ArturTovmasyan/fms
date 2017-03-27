<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Division
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"name", "subordination", "type"}, errorPath="name", message="division.error.unique")
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
     *
     * @ORM\ManyToOne(targetEntity="Division",cascade={"persist"})
     * @ORM\JoinColumn(name="division_id", referencedColumnName="id")
     */
    private $subordination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     *
     * @ORM\Column(name="orders", type="string", nullable=true)
     */
    private $orders;

    /**
     *
     * @ORM\Column(name="head_position", type="string")
     */
    private $headPosition;

    /**
     * @ORM\ManyToOne(targetEntity="DivisionType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="division", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $post;

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

    /**
     * @return string
     */
    function __toString()
    {
        return ((string)$this->headPosition) ? (string)$this->headPosition : '';
    }


    /**
     * Set subordination
     *
     * @param \MainBundle\Entity\Division $subordination
     * @return Division
     */
    public function setSubordination(\MainBundle\Entity\Division $subordination = null)
    {
        $this->subordination = $subordination;

        return $this;
    }

    /**
     * Get subordination
     *
     * @return \MainBundle\Entity\Division 
     */
    public function getSubordination()
    {
        return $this->subordination;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add post
     *
     * @param \MainBundle\Entity\Post $post
     * @return Division
     */
    public function addPost(\MainBundle\Entity\Post $post)
    {
        $post->setDivision($this);
        $this->post[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \MainBundle\Entity\Post $post
     */
    public function removePost(\MainBundle\Entity\Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPost()
    {
        return $this->post;
    }
}
