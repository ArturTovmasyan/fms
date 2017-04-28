<?php

namespace MainBundle\Traits\Resource;

use Doctrine\ORM\PersistentCollection;

/**
 * Class Product
 * @package MainBundle\Traits\Resource
 */
trait Product
{
    /**
     * @param $object
     */
    public function setRelations($object)
    {
        //get product raw expenses
        $productRawExpense = $object->getProductRawExpense();

        //if product raw expenses is exist
        if($productRawExpense) {

            foreach($productRawExpense as $productRawExpens)
            {
                if(!$productRawExpens->getId() || !$productRawExpense->contains($object)) {
                    $productRawExpens->setProduct($object);
                }
            }
        }

        //get product components
        $productComponents = $object->getProductComponent();

        // if product component exist
        if($productComponents) {

            foreach($productComponents as $productComponent)
            {
                if(!$productComponent->getId()) {
                    $productComponent->setProduct($object);
                }

                $routeCards = $productComponent->getRouteCard();

                if(count($routeCards) > 0) {
                    foreach ($routeCards as $routeCard)
                    {
                        $routeCard->setProductComponent($productComponent);
                    }
                }
            }
        }
    }

    /**
     * @param $object
     */
    public function removeRelations($object)
    {
        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //get entity manager
        $em = $container->get('doctrine')->getManager();

        // get productRawExpenses
        $productRawExpense = $object->getProductRawExpense();

        if($productRawExpense) {
            //get delete diff
            $rawExpenseRemoved = $productRawExpense->getDeleteDiff();

            //removed raw expense
            if(count($rawExpenseRemoved) > 0) {
                foreach ($rawExpenseRemoved as $remove)
                {
                    $em->remove($remove);
                }
            }
        }

        //product components
        $productComponents = $object->getProductComponent();

        if($productComponents) {

            //get delete diff
            $componentsRemoved = $productComponents->getDeleteDiff();

            //removed raw expense
            if(count($componentsRemoved) > 0) {
                foreach ($componentsRemoved as $remove)
                {
                    $em->remove($remove);
                }
            }

            foreach ($productComponents as $productComponent)
            {
                $routeCards = $productComponent->getRouteCard();

                if($routeCards instanceof PersistentCollection) {
                    //get delete diff
                    $routeCardsRemoved = $routeCards->getDeleteDiff();

                    //removed raw expense
                    if($routeCardsRemoved) {
                        foreach ($routeCardsRemoved as $remove)
                        {
                            $em->remove($remove);
                        }
                    }
                }
            }
        }
    }
}