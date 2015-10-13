<?php

namespace MainBundle\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\PersistentCollection;
use MainBundle\Entity\Product;
use MainBundle\Entity\ProductRouteCard;
use MainBundle\Entity\SalariesType;
use Symfony\Component\DependencyInjection\Container;


/**
 * Class UpdateTariffListener
 * @package MainBundle\EventListener
 */

class UpdateTariffListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * This function is used to update product route card price on flush event
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        // get entity manager
        $em = $args->getEntityManager();

        // get unit work
        $uow = $em->getUnitOfWork();

        // for update
        foreach ($uow->getScheduledEntityUpdates() AS $entity)
        {
            //if product object
            if ($entity instanceof Product) {

                $productCards = $entity->getProductRouteCard();

                $this->getPrice($productCards, $uow, $em);
            }

            //if product route card object
            if ($entity instanceof ProductRouteCard) {

                $productCards = $entity;

                $this->getPrice($productCards, $uow, $em);
            }

            //if salaries type object
            if($entity instanceof SalariesType){

                $this->updatePrice($entity, $uow, $em);
            }
        }

        //for create
        foreach ($uow->getScheduledEntityInsertions() AS $entity)
        {
            //if product object
            if ($entity instanceof ProductRouteCard) {

                $productCards = $entity;

                $this->getPrice($productCards, $uow, $em);
            }
        }

        //for deletions
        foreach ($uow->getScheduledEntityDeletions() AS $entity)
        {
            //if product object
            if ($entity instanceof SalariesType) {

                //TODO
                //get product cards
                $productCards = $entity->getProfession()->getProductRouteCard();

                $productCards->count();
                $this->getPrice($productCards, $uow, $em);
            }
        }
    }

    /**
     * @param SalariesType $entity
     * @param $uow
     * @param $em
     */
    private function updatePrice(SalariesType $entity, $uow, $em)
    {
        $changeSet = $uow->getEntityChangeSet($entity);

        if($changeSet) {

            //get route card
            $routeCards = $entity->getProfession()->getProductRouteCard();

            $this->getPrice($routeCards, $uow, $em);
        }
    }

    /**
     * This function is used to set route card price and get tariff by ids
     * @param $productCards
     * @param $uow
     * @param $em
     */
    private function getPrice($productCards, $uow, $em)
    {
        //if product Cards exist
        if($productCards){

            //check if product cards is not persist collection
            if(!($productCards instanceof PersistentCollection)){
                $productCards = array($productCards);
            }

            foreach($productCards as $productCard) {

                //get profession
                $profession = $productCard->getProfession();

                //get profession category
                $professionCategory = $productCard->getProfessionCategory();

                //get job time
                $jobTime = $productCard->getJobTime();

                //get all salaries type by profession
                $salariesTypeArray = $profession->getSalariesType();

                //get salaries type by profession category id
                $salariesType = $salariesTypeArray[$professionCategory->getId()];

                if($salariesType) {
                    //get hour salary
                    $hourSalary  = $salariesType->getHourSalary();

                    //get route card price
                    $price =  $jobTime * $hourSalary;

//                    dump($price);exit;
                    //set route card price
                    $productCard->setRouteCardPrice($price);
                }
                else {
                    $productCard->setRouteCardPrice(0);
                }
                // persist changes
                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata('MainBundle:ProductRouteCard'), $productCard);
            }
        }
    }
}