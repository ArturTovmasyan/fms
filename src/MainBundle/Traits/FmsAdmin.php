<?php

namespace MainBundle\Traits;

use MainBundle\Entity\ConductiveMaterials;
use MainBundle\Entity\EquipmentImage;
use MainBundle\Entity\HouseholdMaterials;
use MainBundle\Entity\IlliquidMaterials;
use MainBundle\Entity\MetalMaterials;
use MainBundle\Entity\PartnersList;
use MainBundle\Entity\PersonnelImages;
use MainBundle\Entity\PostImages;
use MainBundle\Entity\PrepackMaterials;
use MainBundle\Entity\RawMaterialImages;
use MainBundle\Entity\RubberMaterials;
use MainBundle\Entity\SparePart;
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
        //get data in request
        $data = $this->getRequestData();

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $imagesIds = $data['imageIds'];
        $imagesIds = json_decode($imagesIds, true);
        $ids = explode( ',', $imagesIds);
        $repositoryName = "MainBundle:".$imageClassName;
        $images = $em->getRepository($repositoryName)->findBy(['id'=>$ids]);

        return $images;
    }

    /**
     * This function is used to get request data
     */
    public function getRequestData()
    {
        //get images by ids
        $request = $this->getRequest();
        $uniqId = $this->getUniqid();
        $data = $request->request->get($uniqId);

        return $data;
    }

    /**
     * @param $object
     */
    public function addNewVendor($object)
    {
        //get all request data
        $data = $this->getRequestData();

        //get added vendor value in request
        $newVendor = $data['newVendors'];

        if($newVendor) {

            //create new vendor and related it with current tool
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
            $vendor = new PartnersList();
            $vendor->setName($newVendor);
            $em->persist($vendor);
            $em->flush();
            $object->addVendor($vendor);
        }
    }

    /**
     * @param $object
     */
    public function addNewSparePart($object)
    {
        //get all request data
        $data = $this->getRequestData();

        //get added spare part value in request
        $newSparePart = $data['newSparePart'];

        if($newSparePart) {

            //create new vendor and related it with current tool
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
            $sparePart = new SparePart();
            $sparePart->setName($newSparePart);
            $em->persist($sparePart);
            $em->flush();
            $object->addSparePart($sparePart);
        }
    }
}