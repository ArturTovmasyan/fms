<?php
namespace MainBundle\Entity;

use MainBundle\Traits\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class GoalImage
 * @package MainBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="equipment_image")
 * @ORM\HasLifecycleCallbacks()
 */
class EquipmentImage
{
    // use file trait
    use File;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"image"})
     */
    protected $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    protected $equipment;

    /**
     * @var
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;


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
    public function getImagePath()
    {
        return $this->getDownloadLink();
    }

    /**
     * Override getPath function in file trait
     *
     * @return string
     */
    protected function getPath()
    {
        return 'images';
    }

    /**
     * @param $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $updated
     * @return $this
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
     * Set equipment
     *
     * @param \MainBundle\Entity\Equipment $equipment
     * @return EquipmentImage
     */
    public function setEquipment(\MainBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \MainBundle\Entity\Equipment 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove()
    {
        // get origin file path
        $filePath = $this->getAbsolutePath() . $this->getFileName();

        // check file and remove
        if (file_exists($filePath) && is_file($filePath)){
            unlink($filePath);
        }
    }
}
