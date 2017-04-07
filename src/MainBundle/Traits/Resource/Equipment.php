<?php

namespace MainBundle\Traits\Resource;

/**
 * Class Equipment
 * @package MainBundle\Traits
 */
trait Equipment
{
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

                if(!$removeDefects->contains($object)) {

                    $removeDefect->setEquipment($object);
                }
            }
        }

        //get el powers
        $elPowers = $object->getElPowers();

        if($elPowers) {
            foreach($elPowers as $elPower)
            {

                if(!$elPowers->contains($object)) {

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

            //check deleted defects
            $defects = $removeDefects->getDeleteDiff();

            foreach($defects as $defect)
            {
                $defect->setEquipment(null);
            }
        }

        //remove el powers
        $elPowers = $object->getElPowers();

        if($elPowers) {

            $powers = $elPowers->getDeleteDiff();

            foreach($powers as $power)
            {
                $power->setEquipment(null);
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