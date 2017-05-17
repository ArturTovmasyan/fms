<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archiv
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Archiv
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
     * @var integer
     *
     * @ORM\Column(name="post", type="integer")
     */
    private $post;

    /**
     * @var integer
     *
     * @ORM\Column(name="tools", type="integer")
     */
    private $tools;

    /**
     * @var string
     *
     * @ORM\Column(name="history", type="string", length=255)
     */
    private $history;

//    /**
//     * @ORM\ManyToOne(targetEntity="Personnel", inversedBy="toolsChronology", cascade={"persist"}, fetch="LAZY")
//     * @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
//     */
//    private $personnel;
//
//    /**
//     *
//     * @ORM\ManyToOne(targetEntity="Tools", inversedBy="toolsChronology", cascade={"persist"}, fetch="LAZY")
//     * @ORM\JoinColumn(name="tools_id", referencedColumnName="id")
//     */
//    private $tool;

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
     * @return Archiv
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
     * Set post
     *
     * @param integer $post
     * @return Archiv
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return integer 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set tools
     *
     * @param integer $tools
     * @return Archiv
     */
    public function setTools($tools)
    {
        $this->tools = $tools;

        return $this;
    }

    /**
     * Get tools
     *
     * @return integer 
     */
    public function getTools()
    {
        return $this->tools;
    }

    /**
     * Set history
     *
     * @param string $history
     * @return Archiv
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return string 
     */
    public function getHistory()
    {
        return $this->history;
    }
}
