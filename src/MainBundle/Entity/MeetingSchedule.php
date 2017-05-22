<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeetingSchedule
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MeetingSchedule
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Personnel", cascade={"persist"})
     */
    private $reporter;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="meetingSchedule", cascade={"persist"})
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
     * Set subject
     *
     * @param string $subject
     * @return MeetingSchedule
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set reporter
     *
     * @param string $reporter
     * @return MeetingSchedule
     */
    public function setReporter($reporter)
    {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * Get reporter
     *
     * @return string 
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Set meeting
     *
     * @param \MainBundle\Entity\Meeting $meeting
     * @return MeetingSchedule
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
