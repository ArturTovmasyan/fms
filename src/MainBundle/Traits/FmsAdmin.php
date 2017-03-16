<?php

namespace MainBundle\Traits;

use MainBundle\Entity\EquipmentImage;
use MainBundle\Entity\PrepackMaterials;
use MainBundle\Entity\RawMaterialImages;
use MainBundle\Entity\RubberMaterials;

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
    public function addImages(&$object)
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

                if ($image instanceof EquipmentImage){
                    $image->setEquipment($object);
                }

                if ($image instanceof RawMaterialImages){

                    if($object instanceof PrepackMaterials){
                        $image->setPrepackMaterial($object);
                    }

                    if($object instanceof RubberMaterials){
                        $image->setRubberMaterials($object);
                    }
                }
            }
        }
    }

}