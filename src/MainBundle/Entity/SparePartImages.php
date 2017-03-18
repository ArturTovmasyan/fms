<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * SparePartImages
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SparePartImages implements ImageableInterface
{
    //use file trait
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
     *
     * @ORM\ManyToOne(targetEntity="SparePart", inversedBy="images", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="spare_part_id", referencedColumnName="id")
     */
    protected $sparePart;

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
        return 'sparePart';
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
     * Set sparePart
     *
     * @param \MainBundle\Entity\SparePart $sparePart
     * @return SparePartImages
     */
    public function setSparePart(\MainBundle\Entity\SparePart $sparePart = null)
    {
        $this->sparePart = $sparePart;

        return $this;
    }

    /**
     * Get sparePart
     *
     * @return \MainBundle\Entity\SparePart 
     */
    public function getSparePart()
    {
        return $this->sparePart;
    }
}
