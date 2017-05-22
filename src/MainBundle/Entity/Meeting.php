<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(name="type", type="json_array")
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(name="place", type="json_array", nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(name="subject", type="json_array", nullable=true)
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity="MeetingSchedule", mappedBy="meeting", cascade={"persist"})
     */
    private $meetingSchedule;

    /**
     * @ORM\OneToMany(targetEntity="MeetingTask", mappedBy="meeting", cascade={"persist"})
     */
    private $meetingTask;

    /**
     * @ORM\ManyToMany(targetEntity="Personnel", fetch="EXTRA_LAZY")
     */
    private $member;

    /**
     * @ORM\Column(name="listen", type="json_array", nullable=true)
     */
    private $listen;

    /**
     * @ORM\Column(name="decided", type="json_array", nullable=true)
     */
    private $decided;

    /**
     * @ORM\ManyToMany(targetEntity="Invitors", fetch="EXTRA_LAZY")
     */
    private $invitors;

    /**
     * @var string
     *
     * @ORM\Column(name="tasks", type="string", length=255, nullable=true)
     */
    private $tasks;

    /**
     * @ORM\Column(name="chairPerson", type="json_array", nullable=true)
     */
    private $chairPerson;

    /**
     * @ORM\Column(name="secretary", type="json_array", nullable=true)
     */
    private $secretary;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

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
     * @return string
     */
    function __toString()
    {
        return (string)($this->id) ? (string)($this->id) : '';
    }

    /**
     * This function is used to get time in date object
     */
    public function getTime()
    {
        $time = $this->getDate();
        $time = $time ? $time->format('H:i:s') : null;

        return $time;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meetingSchedule = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add meetingSchedule
     *
     * @param \MainBundle\Entity\MeetingSchedule $meetingSchedule
     * @return Meeting
     */
    public function addMeetingSchedule(\MainBundle\Entity\MeetingSchedule $meetingSchedule)
    {
        $this->meetingSchedule[] = $meetingSchedule;

        return $this;
    }

    /**
     * Remove meetingSchedule
     *
     * @param \MainBundle\Entity\MeetingSchedule $meetingSchedule
     */
    public function removeMeetingSchedule(\MainBundle\Entity\MeetingSchedule $meetingSchedule)
    {
        $this->meetingSchedule->removeElement($meetingSchedule);
    }

    /**
     * Get meetingSchedule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMeetingSchedule()
    {
        return $this->meetingSchedule;
    }

    /**
     * Add meetingTask
     *
     * @param \MainBundle\Entity\MeetingTask $meetingTask
     * @return Meeting
     */
    public function addMeetingTask(\MainBundle\Entity\MeetingTask $meetingTask)
    {
        $this->meetingTask[] = $meetingTask;

        return $this;
    }

    /**
     * Remove meetingTask
     *
     * @param \MainBundle\Entity\MeetingTask $meetingTask
     */
    public function removeMeetingTask(\MainBundle\Entity\MeetingTask $meetingTask)
    {
        $this->meetingTask->removeElement($meetingTask);
    }

    /**
     * Get meetingTask
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMeetingTask()
    {
        return $this->meetingTask;
    }

    /**
     * Set invitors
     *
     * @param array $invitors
     * @return Meeting
     */
    public function setInvitors($invitors)
    {
        $this->invitors = $invitors;

        return $this;
    }

    /**
     * Get invitors
     *
     * @return array 
     */
    public function getInvitors()
    {
        return $this->invitors;
    }

    /**
     * Add invitors
     *
     * @param \MainBundle\Entity\Invitors $invitors
     * @return Meeting
     */
    public function addInvitor(\MainBundle\Entity\Invitors $invitors)
    {
        $this->invitors[] = $invitors;

        return $this;
    }

    /**
     * Remove invitors
     *
     * @param \MainBundle\Entity\Invitors $invitors
     */
    public function removeInvitor(\MainBundle\Entity\Invitors $invitors)
    {
        $this->invitors->removeElement($invitors);
    }

    /**
     * Add member
     *
     * @param \MainBundle\Entity\Personnel $member
     * @return Meeting
     */
    public function addMember(\MainBundle\Entity\Personnel $member)
    {
        $this->member[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \MainBundle\Entity\Personnel $member
     */
    public function removeMember(\MainBundle\Entity\Personnel $member)
    {
        $this->member->removeElement($member);
    }

    /**
     * Get member
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Meeting
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
     * @return Meeting
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
