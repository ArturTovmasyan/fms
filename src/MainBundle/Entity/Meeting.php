<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meeting
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Meeting
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
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text")
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="schedule", type="integer")
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(name="member", type="string", length=255)
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\Column(name="listen", type="string", length=255)
     */
    private $listen;

    /**
     * @var string
     *
     * @ORM\Column(name="decided", type="string", length=255)
     */
    private $decided;

    /**
     * @var string
     *
     * @ORM\Column(name="tasks", type="string", length=255)
     */
    private $tasks;

    /**
     * @var integer
     *
     * @ORM\Column(name="chairPerson", type="integer")
     */
    private $chairPerson;

    /**
     * @var integer
     *
     * @ORM\Column(name="secretary", type="integer")
     */
    private $secretary;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

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
     * Set status
     *
     * @param integer $status
     * @return Meeting
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Meeting
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Meeting
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
     * Set place
     *
     * @param string $place
     * @return Meeting
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Meeting
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
     * Set schedule
     *
     * @param integer $schedule
     * @return Meeting
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return integer 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Set member
     *
     * @param string $member
     * @return Meeting
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return string 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set listen
     *
     * @param string $listen
     * @return Meeting
     */
    public function setListen($listen)
    {
        $this->listen = $listen;

        return $this;
    }

    /**
     * Get listen
     *
     * @return string 
     */
    public function getListen()
    {
        return $this->listen;
    }

    /**
     * Set decided
     *
     * @param string $decided
     * @return Meeting
     */
    public function setDecided($decided)
    {
        $this->decided = $decided;

        return $this;
    }

    /**
     * Get decided
     *
     * @return string 
     */
    public function getDecided()
    {
        return $this->decided;
    }

    /**
     * Set tasks
     *
     * @param string $tasks
     * @return Meeting
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get tasks
     *
     * @return string 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set chairPerson
     *
     * @param integer $chairPerson
     * @return Meeting
     */
    public function setChairPerson($chairPerson)
    {
        $this->chairPerson = $chairPerson;

        return $this;
    }

    /**
     * Get chairPerson
     *
     * @return integer 
     */
    public function getChairPerson()
    {
        return $this->chairPerson;
    }

    /**
     * Set secretary
     *
     * @param integer $secretary
     * @return Meeting
     */
    public function setSecretary($secretary)
    {
        $this->secretary = $secretary;

        return $this;
    }

    /**
     * Get secretary
     *
     * @return integer 
     */
    public function getSecretary()
    {
        return $this->secretary;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Meeting
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }
}
