<?php

namespace MainBundle\Traits\Resource;

/**
 * Class Equipment
 * @package MainBundle\Traits
 */
trait Equipment
{
    /**
     * Add some fields from mapped entities; the simplest way;
     * @return array
     */
    public function getExportFields()
    {
        //set default null value
        $showFields = null;
        $showFields = null;

        //get cookies data
        $cookies = $this->getRequest()->cookies;

        if ($cookies->has('EQUIPMENT_FILTERS')) {
            $showFields = unserialize($cookies->get('EQUIPMENT_FILTERS'));
        }

        if($showFields) {

            if(array_key_exists('workshop', $showFields)) {
                $showFields['workshop'] = 'getWorkshopString';
            }
            if(array_key_exists('product', $showFields)) {
                $showFields['product'] = 'getProductsString';
            }
            if(array_key_exists('mould', $showFields)) {
                $showFields['mould'] = 'getMouldsString';
            }
            if(array_key_exists('deployment', $showFields)) {
                $showFields['deployment'] = 'getDeploymentString';
            }
            if(array_key_exists('type', $showFields)) {
                $showFields['type'] = 'getTypeString';
            }
            if(array_key_exists('responsiblePersons', $showFields)) {
                $showFields['responsiblePersons'] = 'getPersonString';
            }
            if(array_key_exists('eqState', $showFields)) {
                $showFields['eqState'] = 'getStateString';
            }
            if(array_key_exists('image', $showFields)) {
                $showFields['image'] = 'getFilesString';
            }
            if(array_key_exists('length', $showFields)) {
                $showFields['length'] = 'getOverSize';
            }
            if(array_key_exists('removeDefects', $showFields)) {
                $showFields['removeDefects'] = 'getDefectsString';
            }
            if(array_key_exists('elPowers', $showFields)) {
                $showFields['elPowers'] = 'getElPowerSum';
            }

            $fieldsArray = $showFields;

        }else{

            $fieldsArray = $this->getModelManager()->getExportFields($this->getClass());

            //add custom get string functions for relations
            $fieldsArray[] = 'getOverSize';
            $fieldsArray[] = 'getProductsString';
            $fieldsArray[] = 'getMouldsString';
            $fieldsArray[] = 'getWorkshopString';
            $fieldsArray[] = 'getStateString';
            $fieldsArray[] = 'getDeploymentString';
            $fieldsArray[] = 'getTypeString';
            $fieldsArray[] = 'getPersonString';
            $fieldsArray[] = 'getFilesString';
            $fieldsArray[] = 'getDefectsString';
            $fieldsArray[] = 'getElPowerSum';
        }

        return $fieldsArray;
    }

    /**
     * @return array
     */
    public function getExportFormats()
    {
        return [
            'csv', 'xls'
        ];
    }

    //set relations for Equipment
    public function setRelations($object)
    {
        // add products
        $products = $object->getProduct();

        if($products) {
            foreach($products as $product)
            {
                $productEquipment = $product->getEquipment();

                if(!$productEquipment->contains($object))
                {
                    $product->addEquipment($object);
                }
            }
        }


        // add remove defects
        $removeDefects = $object->getRemoveDefects();

        if($removeDefects) {
            foreach($removeDefects as $removeDefect)
            {
                if(!$removeDefect->getId()) {
                    $removeDefect->setEquipment($object);
                }
            }
        }

        //get el powers
        $elPowers = $object->getElPowers();

        if($elPowers) {

            foreach($elPowers as $elPower)
            {

                if(!$elPower->getId()) {
                    $elPower->setEquipment($object);
                }
            }
        }

        // add spares
        $spares = $object->getSpares();

        if($spares) {
            foreach($spares as $spare)
            {
                if(!$spares->contains($object)){

                    $spare->setEquipment($object);
                }
            }
        }


        // add moulds
        $moulds = $object->getMould();

        if($moulds) {
            foreach($moulds as $mould)
            {
                $mouldEquipment = $mould->getEquipment();

                if(!$mouldEquipment->contains($object)){

                    $mould->addEquipment($object);
                }
            }
        }

    }

    public function removeRelations($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine')->getManager();

        //get products
        $products = $object->getProduct();

        //get removed products in Equipment
        $removed = $products->getDeleteDiff();

        if($removed) {
            foreach($removed as $remove)
            {
                $remove->removeEquipment($object);
            }
        }

        //remove spares
        $spares = $object->getSpares();

        if($spares) {

            //check deleted spares
            $removedSpares = $spares->getDeleteDiff();

            foreach($removedSpares as $removedSpare)
            {
                $removedSpare->setEquipment(null);
            }
        }

        //remove defects
        $removeDefects = $object->getRemoveDefects();

        if($removeDefects) {

            $methods = get_class_methods($removeDefects);

            //check deleted defects
            $defects = $removeDefects->getDeleteDiff();

            foreach($defects as $defect)
            {
                $em->remove($defect);
            }
        }

        //remove el powers
        $elPowers = $object->getElPowers();

        if($elPowers) {

            $powers = $elPowers->getDeleteDiff();

            foreach($powers as $power)
            {
                $em->remove($power);
            }
        }

        // remove moulds
        $moulds = $object->getMould();

        if($moulds) {

            //check deleted moulds
            $removedMoulds = $moulds->getDeleteDiff();

            foreach($removedMoulds as $removedMould)
            {
                $removedMould->removeEquipment($object);
            }
        }
    }

}