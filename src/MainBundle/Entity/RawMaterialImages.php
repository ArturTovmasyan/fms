<?php
namespace MainBundle\Entity;

use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class RawMaterialImages
 * @package MainBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="raw_material_images")
 * @ORM\HasLifecycleCallbacks()
 */
class RawMaterialImages implements ImageableInterface
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
     * @ORM\ManyToOne(targetEntity="PrepackMaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="prepack_material_id", referencedColumnName="id")
     */
    protected $prepackMaterial;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Rubbermaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="rubber_material_id", referencedColumnName="id")
     */
    protected $rubberMaterials;

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
        return 'material';
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
     * Set prepackMaterial
     *
     * @param \MainBundle\Entity\PrepackMaterials $prepackMaterial
     * @return RawMaterialImages
     */
    public function setPrepackMaterial(\MainBundle\Entity\PrepackMaterials $prepackMaterial = null)
    {
        $this->prepackMaterial = $prepackMaterial;

        return $this;
    }

    /**
     * Get prepackMaterial
     *
     * @return \MainBundle\Entity\PrepackMaterials 
     */
    public function getPrepackMaterial()
    {
        return $this->prepackMaterial;
    }

    /**
     * Set rubberMaterials
     *
     * @param \MainBundle\Entity\Rubbermaterials $rubberMaterials
     * @return RawMaterialImages
     */
    public function setRubberMaterials(\MainBundle\Entity\Rubbermaterials $rubberMaterials = null)
    {
        $this->rubberMaterials = $rubberMaterials;

        return $this;
    }

    /**
     * Get rubberMaterials
     *
     * @return \MainBundle\Entity\Rubbermaterials 
     */
    public function getRubberMaterials()
    {
        return $this->rubberMaterials;
    }
}
