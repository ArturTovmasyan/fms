<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\DisableAwareInterface;
use MainBundle\Traits\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * Personnel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\PersonnelRepository")
 */
class Personnel implements DisableAwareInterface
{
    // use file trait
    use File;

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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="Post", inversedBy="personnel", cascade={"persist"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\OneToMany(targetEntity="PostHistory", mappedBy="personnel", cascade={"persist", "remove"})
     **/
    protected $history;

    /**
     * @var string
     *
     * @ORM\Column(name="birth_date", type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="position_date", type="datetime", nullable=true)
     */
    private $positionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=30, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="fixed_phone", type="string", length=30, nullable=true)
     */
    private $fixedPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="alternate_phone", type="string", length=30, nullable=true)
     */
    private $alternatePhone;

    /**
     * @var string
     *
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=30, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="car_number", type="string", length=15, nullable=true)
     */
    private $carNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=80, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="husband", type="string", length=20, nullable=true)
     */
    private $husband;

    /**
     * @var string
     *
     * @ORM\Column(name="children", type="string", length=20, nullable=true)
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(name="parent", type="string", length=20, nullable=true)
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="sister", type="string", length=20, nullable=true)
     */
    private $sister;

    /**
     * @var string
     *
     * @ORM\Column(name="brother", type="string", length=20, nullable=true)
     */
    private $brother;

    /**
     * @var string
     *
     * @ORM\Column(name="education", type="smallint", nullable=true)
     */
    private $education;

    /**
     * @ORM\OneToOne(targetEntity="Diploma", cascade={"persist", "remove"})
     */
    private $diploma;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", nullable=true)
     */
    private $profession;

    /**
     * @ORM\OneToMany(targetEntity="ToolsChronology", mappedBy="personnel", cascade={"persist", "remove"})
     */
    private $toolsChronology;

    /**
     *
     * @ORM\Column(name="language", type="json_array", nullable=true)
     */
    private $language;

    /**
     *
     * @ORM\Column(name="comp_knowledge", type="json_array", nullable=true)
     */
    private $compKnowledge;

    /**
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled = false;

    private $awards;
    private $remarks;
    private $tabel;
    private $salaryCard;

    /**
     * @ORM\ManyToMany(targetEntity="Equipment", mappedBy="responsiblePersons", fetch="EXTRA_LAZY")
     */
    private $equipment;

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
     * Constructor
     */
    public function __construct()
    {
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->getDownloadLink();
    }

    /**
     * This function is used to get cut name
     *
     * @return mixed
     */
    public function getCutName()
    {
       $fullName = $this->name;
       $fullName = explode(' ', $fullName);
       return $fullName[0];
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)($this->name) ? (string)($this->name) : '';
    }

    /**
     * Add equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return Personnel
     */
    public function addEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\MainBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Personnel
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
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Personnel
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set positionDate
     *
     * @param \DateTime $positionDate
     * @return Personnel
     */
    public function setPositionDate($positionDate)
    {
        $this->positionDate = $positionDate;

        return $this;
    }

    /**
     * Get positionDate
     *
     * @return \DateTime 
     */
    public function getPositionDate()
    {
        return $this->positionDate;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     * @return Personnel
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set fixedPhone
     *
     * @param string $fixedPhone
     * @return Personnel
     */
    public function setFixedPhone($fixedPhone)
    {
        $this->fixedPhone = $fixedPhone;

        return $this;
    }

    /**
     * Get fixedPhone
     *
     * @return string 
     */
    public function getFixedPhone()
    {
        return $this->fixedPhone;
    }

    /**
     * Set alternatePhone
     *
     * @param string $alternatePhone
     * @return Personnel
     */
    public function setAlternatePhone($alternatePhone)
    {
        $this->alternatePhone = $alternatePhone;

        return $this;
    }

    /**
     * Get alternatePhone
     *
     * @return string 
     */
    public function getAlternatePhone()
    {
        return $this->alternatePhone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Personnel
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set carNumber
     *
     * @param string $carNumber
     * @return Personnel
     */
    public function setCarNumber($carNumber)
    {
        $this->carNumber = $carNumber;

        return $this;
    }

    /**
     * Get carNumber
     *
     * @return string 
     */
    public function getCarNumber()
    {
        return $this->carNumber;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Personnel
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set husband
     *
     * @param string $husband
     * @return Personnel
     */
    public function setHusband($husband)
    {
        $this->husband = $husband;

        return $this;
    }

    /**
     * Get husband
     *
     * @return string 
     */
    public function getHusband()
    {
        return $this->husband;
    }

    /**
     * Set children
     *
     * @param string $children
     * @return Personnel
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param string $parent
     * @return Personnel
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set sister
     *
     * @param string $sister
     * @return Personnel
     */
    public function setSister($sister)
    {
        $this->sister = $sister;

        return $this;
    }

    /**
     * Get sister
     *
     * @return string 
     */
    public function getSister()
    {
        return $this->sister;
    }

    /**
     * Set brother
     *
     * @param string $brother
     * @return Personnel
     */
    public function setBrother($brother)
    {
        $this->brother = $brother;

        return $this;
    }

    /**
     * Get brother
     *
     * @return string 
     */
    public function getBrother()
    {
        return $this->brother;
    }

    /**
     * Set education
     *
     * @param integer $education
     * @return Personnel
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return integer 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set profession
     *
     * @param string $profession
     * @return Personnel
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string 
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set language
     *
     * @param integer $language
     * @return Personnel
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return integer 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Personnel
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
     * @return Personnel
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

    /**
     * Set compKnowledge
     *
     * @param string $compKnowledge
     * @return Personnel
     */
    public function setCompKnowledge($compKnowledge)
    {
        $this->compKnowledge = $compKnowledge;

        return $this;
    }

    /**
     * Get compKnowledge
     *
     * @return string 
     */
    public function getCompKnowledge()
    {
        return $this->compKnowledge;
    }

    /**
     * Set post
     *
     * @param \MainBundle\Entity\Post $post
     * @return Personnel
     */
    public function setPost(\MainBundle\Entity\Post $post = null)
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
     * Add history
     *
     * @param \MainBundle\Entity\PostHistory $history
     * @return Personnel
     */
    public function addHistory(\MainBundle\Entity\PostHistory $history)
    {
        $history->setPersonnel($this);
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \MainBundle\Entity\PostHistory $history
     */
    public function removeHistory(\MainBundle\Entity\PostHistory $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set diploma
     *
     * @param \MainBundle\Entity\Diploma $diploma
     * @return Personnel
     */
    public function setDiploma(\MainBundle\Entity\Diploma $diploma = null)
    {
        $this->diploma = $diploma;

        return $this;
    }

    /**
     * Get diploma
     *
     * @return \MainBundle\Entity\Diploma 
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * @return Diploma|null
     */
    public function getDiplomaCount()
    {
        // get images
        $files = $this->getDiploma();

        // check images
        if($files){

            $count = count($files);

            return $count;
        }

        return null;
    }

    /**
     * Add toolsChronology
     *
     * @param \MainBundle\Entity\ToolsChronology $toolsChronology
     * @return Personnel
     */
    public function addToolsChronology(\MainBundle\Entity\ToolsChronology $toolsChronology)
    {
        $this->toolsChronology[] = $toolsChronology;

        return $this;
    }

    /**
     * Remove toolsChronology
     *
     * @param \MainBundle\Entity\ToolsChronology $toolsChronology
     */
    public function removeToolsChronology(\MainBundle\Entity\ToolsChronology $toolsChronology)
    {
        $this->toolsChronology->removeElement($toolsChronology);
    }

    /**
     * Get toolsChronology
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getToolsChronology()
    {
        return $this->toolsChronology;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     * @return Personnel
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean 
     */
    public function getDisabled()
    {
        return $this->disabled;
    }
}
