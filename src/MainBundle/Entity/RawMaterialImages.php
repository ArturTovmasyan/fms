<?php
namespace MainBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use MainBundle\Model\ImageableInterface;
use MainBundle\Traits\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * Class RawMaterialImages
 * @package MainBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="raw_material_images")
 * @ORM\HasLifecycleCallbacks()
 */
class RawMaterialImages implements ImageableInterface
{
    //use file trait
    use File;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"files"})
     */
    protected $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="PrepackMaterials", inversedBy="images", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="prepack_material_id", referencedColumnName="id")
     */
    protected $prepackMaterial;

    /**
     *
     * @ORM\ManyToOne(targetEntity="RubberMaterials", inversedBy="images", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="rubber_material_id", referencedColumnName="id")
     */
    protected $rubberMaterials;

    /**
     *
     * @ORM\ManyToOne(targetEntity="HouseholdMaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="household_material_id", referencedColumnName="id")
     */
    protected $householdMaterials;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ConductiveMaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="conductive_material_id", referencedColumnName="id")
     */
    protected $conductiveMaterials;

    /**
     *
     * @ORM\ManyToOne(targetEntity="IlliquidMaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="illiquid_material_id", referencedColumnName="id")
     */
    protected $illiquidMaterials;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MetalMaterials", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="metal_material_id", referencedColumnName="id")
     */
    protected $metalMaterials;

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


    /**
     * Set householdMaterials
     *
     * @param \MainBundle\Entity\HouseholdMaterials $householdMaterials
     * @return RawMaterialImages
     */
    public function setHouseholdMaterials(\MainBundle\Entity\HouseholdMaterials $householdMaterials = null)
    {
        $this->householdMaterials = $householdMaterials;

        return $this;
    }

    /**
     * Get householdMaterials
     *
     * @return \MainBundle\Entity\HouseholdMaterials 
     */
    public function getHouseholdMaterials()
    {
        return $this->householdMaterials;
    }

    /**
     * Set conductiveMaterials
     *
     * @param \MainBundle\Entity\ConductiveMaterials $conductiveMaterials
     * @return RawMaterialImages
     */
    public function setConductiveMaterials(\MainBundle\Entity\ConductiveMaterials $conductiveMaterials = null)
    {
        $this->conductiveMaterials = $conductiveMaterials;

        return $this;
    }

    /**
     * Get conductiveMaterials
     *
     * @return \MainBundle\Entity\ConductiveMaterials 
     */
    public function getConductiveMaterials()
    {
        return $this->conductiveMaterials;
    }

    /**
     * Set illiquidMaterials
     *
     * @param \MainBundle\Entity\IlliquidMaterials $illiquidMaterials
     * @return RawMaterialImages
     */
    public function setIlliquidMaterials(\MainBundle\Entity\IlliquidMaterials $illiquidMaterials = null)
    {
        $this->illiquidMaterials = $illiquidMaterials;

        return $this;
    }

    /**
     * Get illiquidMaterials
     *
     * @return \MainBundle\Entity\IlliquidMaterials 
     */
    public function getIlliquidMaterials()
    {
        return $this->illiquidMaterials;
    }

    /**
     * Set metalMaterials
     *
     * @param \MainBundle\Entity\Metalmaterials $metalMaterials
     * @return RawMaterialImages
     */
    public function setMetalMaterials(\MainBundle\Entity\Metalmaterials $metalMaterials = null)
    {
        $this->metalMaterials = $metalMaterials;

        return $this;
    }

    /**
     * Get metalMaterials
     *
     * @return \MainBundle\Entity\Metalmaterials 
     */
    public function getMetalMaterials()
    {
        return $this->metalMaterials;
    }
}
