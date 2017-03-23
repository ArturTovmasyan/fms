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
     * @Groups({"files"})
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

    /**
     * Set path
     *
     * @param string $path
     * @return SparePartImages
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
