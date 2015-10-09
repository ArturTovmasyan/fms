<?php

namespace MainBundle\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use MainBundle\Entity\ProductRouteCard;
use Symfony\Component\DependencyInjection\Container;


/**
 * Listener for sum price routing card
 *
 * Class DoctrineFilterListener
 * @package Ads\MainBundle\EventListener
 */
class RawCardPriceSumListener
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
     * This listener is used to sum price for product routing card
     *
     * @param $args
     */
    public function postLoad($args)
    {
        // get entity
        $entity = $args->getEntity();

        //get entity manager
        $em = $this->container->get('doctrine')->getEntityManager();

        // have entity ProductRouteCard
        if ($entity instanceof ProductRouteCard)
        {
            $routeCardId = $entity->getId();


//            $price = $em->getRepository('MainBundle:ProductRouteCard')->getRawCardSumByIds($routeCardId);
//
//            dump($price);exit;

        }

    }

}