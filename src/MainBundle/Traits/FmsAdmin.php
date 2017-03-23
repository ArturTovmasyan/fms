<?php

namespace MainBundle\Traits;

use MainBundle\Entity\ConductiveMaterials;
use MainBundle\Entity\EquipmentImage;
use MainBundle\Entity\HouseholdMaterials;
use MainBundle\Entity\IlliquidMaterials;
use MainBundle\Entity\MetalMaterials;
use MainBundle\Entity\PrepackMaterials;
use MainBundle\Entity\RawMaterialImages;
use MainBundle\Entity\RubberMaterials;
use MainBundle\Entity\SparePartImages;
use MainBundle\Entity\ToolImages;

/**
 * Class FmsAdmin
 * @package MainBundle\Traits
 */
trait FmsAdmin
{
    /**
     * This function is used to upload file
     *
     * @param $object
     * @param $images
     */
    private function addImages(&$object, $images)
    {
        // check and set relation for images
        if($images) {

            // loop for images
            foreach($images as $image)
            {
                if(!$image->getId() && !$image->getFile()){
                    continue;
                }

                //set relation for image
                if ($image instanceof SparePartImages){
                    $image->setSparePart($object);
                }

                //set relation for image
                if ($image instanceof EquipmentImage){
                    $image->setEquipment($object);
                }

                if ($image instanceof ToolImages){
                    $image->setTool($object);
                }

                if ($image instanceof RawMaterialImages) {
                    $this->setRawMaterialsImage($image, $object);
                }
            }
        }
    }

    /**
     * This function is used to set raw materials images
     *
     * @param $image
     * @param $object
     */
    private function setRawMaterialsImage($image, &$object)
    {
        if($object instanceof PrepackMaterials){
            $image->setPrepackMaterial($object);
        }
        elseif($object instanceof RubberMaterials){
            $image->setRubberMaterials($object);
        }
        elseif($object instanceof ConductiveMaterials){
            $image->setConductiveMaterials($object);
        }
        elseif($object instanceof IlliquidMaterials){
            $image->setIlliquidMaterials($object);
        }
        elseif($object instanceof HouseholdMaterials){
            $image->setHouseholdMaterials($object);
        }
        elseif($object instanceof MetalMaterials){
            $image->setMetalMaterials($object);
        }
    }

    /**
     * This function is used to get images by id
     * @param $imageClassName
     * @return array
     */
    public function getImages($imageClassName)
    {
        //get images by ids
        $request = $this->getRequest();
        $uniqId = $this->getUniqid();
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $imagesIds = $request->request->get($uniqId)['imageIds'];
        $imagesIds = json_decode($imagesIds, true);
        $ids = explode( ',', $imagesIds);
        $repositoryName = "MainBundle:".$imageClassName;
        $images = $em->getRepository($repositoryName)->findBy(['id'=>$ids]);

        return $images;
    }

}