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
     */
    private function addImages(&$object)
    {
        $fmsService = $this->getConfigurationPool()->getContainer()->get('fms_service');

        //get images
        $images = $object->getImages();

        // check images
        if($images) {

            // loop for images
            foreach($images as $image) {

                if(!$image->getId() && !$image->getFile()){
                    continue;
                }

                // upload file
                $fmsService->uploadFile($image);

                //set relation for image
                if ($image instanceof EquipmentImage){
                    $image->setEquipment($object);
                }

                if ($image instanceof ToolImages){
                    $image->setTool($object);
                }

                if ($image instanceof SparePartImages){
                    $image->setSparePart($object);
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
}