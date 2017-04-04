<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;

/**
 * Diploma
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Diploma
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getImagePath()
    {
        return $this->getDownloadLink();
    }

}
