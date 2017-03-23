<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * ToolImages
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class ToolImages implements ImageableInterface
{
    //use file trait
    use File;

    /**
     * @var integer
     * @Groups({"files"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Tools", inversedBy="images", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="tools_id", referencedColumnName="id")
     */
    protected $tool;

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
        return 'tool';
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

    /**
     * Set tool
     *
     * @param \MainBundle\Entity\Tools $tool
     * @return ToolImages
     */
    public function setTool(\MainBundle\Entity\Tools $tool = null)
    {
        $this->tool = $tool;

        return $this;
    }

    /**
     * Get tool
     *
     * @return \MainBundle\Entity\Tools 
     */
    public function getTool()
    {
        return $this->tool;
    }
}
