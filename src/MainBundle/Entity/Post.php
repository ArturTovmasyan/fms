<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\PostRepository")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="this code is already exist")
 */
class Post
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
     * @ORM\ManyToMany(targetEntity="Division", inversedBy="post", cascade={"persist"})
     */
    protected $division;

    /**
     * @ORM\OneToOne(targetEntity="Personnel", mappedBy="post")
     */
    protected $personnel;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=20, unique=true)
     * @Assert\NotNull()
     * @Assert\Length(min = 3, max=3)
     * @Assert\Regex("/[0-9]/")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="post_status", type="string", length=20, nullable=true)
     */
    private $postStatus;

    /**
     *
     * @ORM\Column(name="educationStatus", type="smallint", nullable=true)
     */
    private $educationStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=100, nullable=true)
     */
    private $profession;

    /**
     * @ORM\OneToMany(targetEntity="PostImages", mappedBy="post", cascade={"persist", "remove"})
     * @Groups({"files"})
     */
    protected $images;

    /**
     * @var integer
     *
     * @Assert\Length(min = 1, max=3)
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(name="experience", type="string", nullable=true)
     */
    private $experience;

    /**
     *
     * @ORM\Column(name="language", type="json_array")
     */
    private $language;

    /**
     *
     * @ORM\Column(name="comp_knowledge", type="json_array")
     */
    private $compKnowledge;

    /**
     * @var integer
     *
     * @ORM\Column(name="requirement", type="json_array", nullable=true)
     */
    private $requirement;

    /**
     * @var integer
     *
     * @ORM\Column(name="chief", type="integer", nullable=true)
     */
    private $chief;

    /**
     * @var integer
     *
     * @ORM\Column(name="workers", type="integer", nullable=true)
     */
    private $workers;

    /**
     * @var string
     *
     * @ORM\Column(name="functions", type="string", length=60, nullable=true)
     */
    private $functions;

    /**
     * @var string
     *
     * @ORM\Column(name="powers", type="string", length=60, nullable=true)
     */
    private $powers;

    /**
     * @var string
     *
     * @ORM\Column(name="obligations", type="string", length=60, nullable=true)
     */
    private $obligations;

    /**
     * @var string
     *
     * @ORM\Column(name="responsibility", type="string", length=60, nullable=true)
     */
    private $responsibility;

    /**
     * @var string
     *
     * @ORM\Column(name="substitutes", type="integer", nullable=true)
     */
    private $substitutes;

    /**
     * @var string
     *
     * @ORM\Column(name="poxarinvox", type="integer", nullable=true)
     */
    private $poxarinvox;

    /**
     * @var string
     *
     * @ORM\Column(name="instructions", type="string", length=50, nullable=true)
     */
    private $instructions;

    /**
     * @var string
     *
     * @ORM\Column(name="jobAgreement", type="string", length=50, nullable=true)
     */
    private $jobAgreement;

    /**
     * @var string
     *
     * @ORM\Column(name="postStory", type="string", length=50, nullable=true)
     */
    private $postStory;

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
     * @return string
     */
    function __toString()
    {
        return ($this->name) ? $this->name : '';
    }

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
     * @return Post
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
     * Set code
     *
     * @param string $code
     * @return Post
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set postStatus
     *
     * @param string $postStatus
     * @return Post
     */
    public function setPostStatus($postStatus)
    {
        $this->postStatus = $postStatus;

        return $this;
    }

    /**
     * Get postStatus
     *
     * @return string 
     */
    public function getPostStatus()
    {
        return $this->postStatus;
    }

    /**
     * @param $profession
     * @return $this
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
     * Set age
     *
     * @param integer $age
     * @return Post
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Post
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set requirement
     *
     * @param integer $requirement
     * @return Post
     */
    public function setRequirement($requirement)
    {
        $this->requirement = $requirement;

        return $this;
    }

    /**
     * Get requirement
     *
     * @return integer 
     */
    public function getRequirement()
    {
        return $this->requirement;
    }

    /**
     * Set chief
     *
     * @param integer $chief
     * @return Post
     */
    public function setChief($chief)
    {
        $this->chief = $chief;

        return $this;
    }

    /**
     * Get chief
     *
     * @return integer 
     */
    public function getChief()
    {
        return $this->chief;
    }

    /**
     * Set workers
     *
     * @param integer $workers
     * @return Post
     */
    public function setWorkers($workers)
    {
        $this->workers = $workers;

        return $this;
    }

    /**
     * Get workers
     *
     * @return integer 
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * Set functions
     *
     * @param string $functions
     * @return Post
     */
    public function setFunctions($functions)
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * Get functions
     *
     * @return string 
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * Set powers
     *
     * @param string $powers
     * @return Post
     */
    public function setPowers($powers)
    {
        $this->powers = $powers;

        return $this;
    }

    /**
     * Get powers
     *
     * @return string 
     */
    public function getPowers()
    {
        return $this->powers;
    }

    /**
     * Set obligations
     *
     * @param string $obligations
     * @return Post
     */
    public function setObligations($obligations)
    {
        $this->obligations = $obligations;

        return $this;
    }

    /**
     * Get obligations
     *
     * @return string 
     */
    public function getObligations()
    {
        return $this->obligations;
    }

    /**
     * Set responsibility
     *
     * @param string $responsibility
     * @return Post
     */
    public function setResponsibility($responsibility)
    {
        $this->responsibility = $responsibility;

        return $this;
    }

    /**
     * Get responsibility
     *
     * @return string 
     */
    public function getResponsibility()
    {
        return $this->responsibility;
    }

    /**
     * Set substitutes
     *
     * @param string $substitutes
     * @return Post
     */
    public function setSubstitutes($substitutes)
    {
        $this->substitutes = $substitutes;

        return $this;
    }

    /**
     * Get substitutes
     *
     * @return string 
     */
    public function getSubstitutes()
    {
        return $this->substitutes;
    }

    /**
     * Set poxarinvox
     *
     * @param string $poxarinvox
     * @return Post
     */
    public function setPoxarinvox($poxarinvox)
    {
        $this->poxarinvox = $poxarinvox;

        return $this;
    }

    /**
     * Get poxarinvox
     *
     * @return string 
     */
    public function getPoxarinvox()
    {
        return $this->poxarinvox;
    }

    /**
     * Set instructions
     *
     * @param string $instructions
     * @return Post
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return string 
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set jobAgreement
     *
     * @param string $jobAgreement
     * @return Post
     */
    public function setJobAgreement($jobAgreement)
    {
        $this->jobAgreement = $jobAgreement;

        return $this;
    }

    /**
     * Get jobAgreement
     *
     * @return string 
     */
    public function getJobAgreement()
    {
        return $this->jobAgreement;
    }

    /**
     * Set postStory
     *
     * @param string $postStory
     * @return Post
     */
    public function setPostStory($postStory)
    {
        $this->postStory = $postStory;

        return $this;
    }

    /**
     * Get postStory
     *
     * @return string 
     */
    public function getPostStory()
    {
        return $this->postStory;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
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
     * @return Post
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
     * This function is used to get equipment workshop string name
     *
     * @return null|string
     */
    public  function getStringEducation()
    {
        $stringState = null;

        switch($this->educationStatus) {
            case 1:
                $stringState = 'Բարձրագույն';
                break;
            case 2:
                $stringState = 'Միջին մասնագիտական';
                break;
            case 3:
                $stringState = 'Միջնակարգ';
                break;
            case 4:
                $stringState = 'Առանց սահմանափակման';
                break;
            default:
                $stringState= '';
        }

        return $stringState;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->division = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add division
     *
     * @param \MainBundle\Entity\Division $division
     * @return Post
     */
    public function addDivision(\MainBundle\Entity\Division $division)
    {
        $this->division[] = $division;

        return $this;
    }

    /**
     * Remove division
     *
     * @param \MainBundle\Entity\Division $division
     */
    public function removeDivision(\MainBundle\Entity\Division $division)
    {
        $this->division->removeElement($division);
    }

    /**
     * Get division
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set educationStatus
     *
     * @param array $educationStatus
     * @return Post
     */
    public function setEducationStatus($educationStatus)
    {
        $this->educationStatus = $educationStatus;

        return $this;
    }

    /**
     * Get educationStatus
     *
     * @return array 
     */
    public function getEducationStatus()
    {
        return $this->educationStatus;
    }

    /**
     * Set language
     *
     * @param array $language
     * @return Post
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return array 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add images
     *
     * @param \MainBundle\Entity\PostImages $images
     * @return Post
     */
    public function addImage(\MainBundle\Entity\PostImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MainBundle\Entity\PostImages $images
     */
    public function removeImage(\MainBundle\Entity\PostImages $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return bool|mixed
     */
    public function getPostImages()
    {
        // get images
        $files = $this->getImages();

        // check images
        if($files){

            return $files;
        }

        return null;
    }

    /**
     * Set compKnowledge
     *
     * @param array $compKnowledge
     * @return Post
     */
    public function setCompKnowledge($compKnowledge)
    {
        $this->compKnowledge = $compKnowledge;

        return $this;
    }

    /**
     * Get compKnowledge
     *
     * @return array 
     */
    public function getCompKnowledge()
    {
        return $this->compKnowledge;
    }

    /**
     * Set personnel
     *
     * @param \MainBundle\Entity\Personnel $personnel
     * @return Post
     */
    public function setPersonnel(\MainBundle\Entity\Personnel $personnel = null)
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
