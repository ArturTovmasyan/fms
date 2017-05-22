<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeetingTask
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MeetingTask
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
     * @ORM\ManyToOne(targetEntity="Personnel", cascade={"persist"})
     */
    private $delegate;

    /**
     * @ORM\ManyToOne(targetEntity="Personnel", cascade={"persist"})
     */
    private $recipient;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="meetingTask", cascade={"persist"})
     */
    private $meeting;

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
     * Set delegate
     *
     * @param string $delegate
     * @return MeetingTask
     */
    public function setDelegate($delegate)
    {
        $this->delegate = $delegate;

        return $this;
    }

    /**
     * Get delegate
     *
     * @return string 
     */
    public function getDelegate()
    {
        return $this->delegate;
    }

    /**
     * Set recipient
     *
     * @param string $recipient
     * @return MeetingTask
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return string 
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MeetingTask
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return MeetingTask
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set meeting
     *
     * @param \MainBundle\Entity\Meeting $meeting
     * @return MeetingTask
     */
    public function setMeeting(\MainBundle\Entity\Meeting $meeting = null)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get meeting
     *
     * @return \MainBundle\Entity\Meeting 
     */
    public function getMeeting()
    {
        return $this->meeting;
    }
}
