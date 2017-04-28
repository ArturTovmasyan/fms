<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;
use JMS\Serializer\Annotation\Groups;

/**
 * PersonnelImages
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PersonnelImages implements ImageableInterface
{
    //use file trait
    use File;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Groups({"files"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

//    /**
//     *
//     * @ORM\ManyToOne(targetEntity="Personnel", inversedBy="images", cascade={"persist"}, fetch="LAZY")
//     * @ORM\JoinColumn(name="personnel_id", referencedColumnName="id")
//     */
//    private $personnel;

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
        return 'personnel';
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
