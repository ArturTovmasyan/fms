<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PostHistory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PostHistory
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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="history", cascade={"persist"})
     * @ORM\JoinColumn(name="posts_id", referencedColumnName="id", nullable=false)
     **/
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Personnel", inversedBy="history")
     * @ORM\JoinColumn(name="personnel_id", referencedColumnName="id", nullable=false)
     **/
    protected $personnel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="from_date", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="to_date", type="datetime", nullable=true)
     */
    private $toDate;

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
     * @return string
     */
    function __toString()
    {
        return (string)($this->id) ? (string)($this->id): '';
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     * @return PostHistory
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime 
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     * @return PostHistory
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Get toDate
     *
     * @return \DateTime 
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set post
     *
     * @param \MainBundle\Entity\Post $post
     * @return PostHistory
     */
    public function setPost(\MainBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \MainBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set personnel
     *
     * @param \MainBundle\Entity\Personnel $personnel
     * @return PostHistory
     */
    public function setPersonnel(\MainBundle\Entity\Personnel $personnel)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return \MainBundle\Entity\Personnel 
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }
}
