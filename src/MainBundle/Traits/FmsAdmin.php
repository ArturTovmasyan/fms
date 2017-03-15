<?php

namespace MainBundle\Traits;

use MainBundle\Entity\EquipmentImage;

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

//                if (!($image instanceof EquipmentImage)){
//                    $object->removeImage($image);
//                    continue;
//                }

                if(!$image->getId() && !$image->getFile()){
                    continue;
                }

                // upload file
                $fmsService->uploadFile($image);

                $image->setEquipment($object);
            }
        }
    }

}