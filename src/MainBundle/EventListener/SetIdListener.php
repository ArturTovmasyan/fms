<?php

namespace MainBundle\EventListener;

use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use MainBundle\Entity\Production;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;


/**
 * Class SetIdListener
 * @package MainBundle\EventListener
 */
class SetIdListener
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
     * This listener is used to set Ad`s district, in flush event
     *
     * @param OnFlushEventArgs $args
     */
    public function OnFlush(OnFlushEventArgs $args)
    {
//        // get token
//        $token = $this->container->get('security.context')->getToken();
//
//        // is token get
//        if($token)
//        {
//            // get current user
//            $user = $this->container->get('security.context')->getToken()->getUser();
//
//            // is user object
//            if(is_object($user))
//            {

                // get entity manager
                $em = $args->getEntityManager();

                // get unit work
                $uow = $em->getUnitOfWork();

                // for insert
                foreach ($uow->getScheduledEntityInsertions() AS $entity)
                {
                    // is Ad`s entity
                    if ($entity instanceof Production)
                    {

                        // persist changes
                        $uow->recomputeSingleEntityChangeSet(
                            $em->getClassMetadata("MainBundle:Production"), $entity);
                    }

//                    dump($entity->getId());exit;

                }

    }
}