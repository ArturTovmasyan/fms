<?php

namespace MainBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use MainBundle\Entity\Personnel;
use MainBundle\Entity\Post;
use MainBundle\Entity\PostHistory;
use MainBundle\Entity\Tariff;
use MainBundle\Entity\Tools;
use MainBundle\Entity\ToolsChronology;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DoctrineListener implements ContainerAwareInterface
{
    /**
     * @var
     */
    public $container;

    protected $histories = [];

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        //get data
        $entity = $args->getObject();

        // check entity
        if($entity instanceof Personnel){

            //get related post
            $post = $entity->getPost();

            if($post){

                //create post history
                $history = new PostHistory();
                $history->setPost($post);
                $history->setPersonnel($entity);
                $this->histories[] = $history;
            }
        }
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        //get data
        $entity = $args->getObject();
        $em = $args->getObjectManager();

        // check entity
        if($entity instanceof Personnel){

            if ($args->hasChangedField('post')) {

                //get all post data
                $oldPost = $args->getOldValue('post');
                $post = $entity->getPost();
                $personnelId = $entity->getId();

                if($post) {

                    //get exist post history
                    $postId = $post->getId();
                    $existHistory = $em->getRepository('MainBundle:PostHistory')->findByPostAndPersonId($postId, $personnelId);

                    if($existHistory) {
                        $history = $existHistory;
                        $history->setFromDate(new \DateTime('now'));
                        $history->setToDate(null);

                    }else{
                        $history = new PostHistory();
                        $history->setPost($post);
                        $history->setPersonnel($entity);
                    }

                    $this->histories[] = $history;
                }

                if($oldPost) {

                    //get exist history data
                    $oldPostId = $oldPost->getId();
                    $existHistory = $em->getRepository('MainBundle:PostHistory')->findByPostAndPersonId($oldPostId, $personnelId);

                    if($existHistory){
                        $existHistory->setToDate(new \DateTime('now'));
                        $this->histories[] = $existHistory;
                    }
                }
            }
        }

        // check entity
        if($entity instanceof Post){

            if ($args->hasChangedField('personnel')) {

                $oldPersonnel = $args->getOldValue('personnel');
                $personnel = $entity->getPersonnel();
                $postId = $entity->getId();

                if($personnel) {

                    //get exist post history
                    $personnelId = $personnel->getId();
                    $existHistory = $em->getRepository('MainBundle:PostHistory')->findByPostAndPersonId($postId, $personnelId);

                    if($existHistory) {
                        $history = $existHistory;
                        $history->setFromDate(new \DateTime('now'));
                        $history->setToDate(null);

                    }else{
                        $history = new PostHistory();
                        $history->setPost($entity);
                        $history->setPersonnel($personnel);
                    }

                    $this->histories[] = $history;
                }

                if($oldPersonnel) {

                    //get exist history data
                    $oldPersonnelId = $oldPersonnel->getId();
                    $existHistory = $em->getRepository('MainBundle:PostHistory')->findByPostAndPersonId($postId, $oldPersonnelId);

                    if($existHistory){
                        $existHistory->setToDate(new \DateTime('now'));
                        $this->histories[] = $existHistory;
                    }
                }
            }
        }
    }

    /**
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event)
    {
        //get history and flush it in database
        $history = $this->histories;

        if(!empty($history)) {

            //get entity manager
            $em = $event->getEntityManager();

            foreach ($history as $hist)
            {
                $em->persist($hist);
            }

            $this->histories = [];
            $em->flush();
        }
    }

    /**
     * This function is used to update route card category after remove it in tariff
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        // get entity manager
        $em = $args->getEntityManager();

        // get unit work
        $uow = $em->getUnitOfWork();

        //for update
        foreach ($uow->getScheduledEntityInsertions() AS $entity)
        {
            $this->changeToolsStatus($entity, $uow, $em);
        }

        //for update
        foreach ($uow->getScheduledEntityUpdates() AS $entity)
        {
           $this->changeToolsStatus($entity, $uow, $em);
        }

        //for deletions
        foreach ($uow->getScheduledEntityDeletions() AS $entity)
        {
            $this->changeToolsStatus($entity, $uow, $em);

            //if product object
            if ($entity instanceof Tariff) {

                //get removed category and profession data
                $removedCategory = $entity->getProfessionCategory()->getName();
                $profession = $entity->getProfession();

                if($profession) {
                    //get route cards
                    $routeCards = $profession->getRouteCard();

                    foreach ($routeCards as $routeCard)
                    {
                        //get route card category
                       $category = $routeCard->getProfessionCategory();

                       $routeCardProf = $routeCard->getProfession();

                       //check if categories is equal
                       if($category == $removedCategory && ($routeCardProf && $profession->getId() == $routeCardProf->getId())) {

                           $routeCard->setProfessionCategory(null);
                           $routeCard->setTariff(0);
                           $routeCard->setSum(0);

                           // persist changes
                           $uow->recomputeSingleEntityChangeSet($em->getClassMetadata('MainBundle:RouteCard'), $routeCard);
                       }
                    }
                }
            }
        }
    }

    /**
     * This function is used to change tolls busy status dynamically
     *
     * @param $entity
     * @param $uow
     * @param $em
     */
    private function changeToolsStatus($entity, $uow, $em)
    {
        //check entity
        if ($entity instanceof ToolsChronology) {

            //check if tool have chronology with personnel
            $tool = $entity->getTool();

            if (count($tool) > 0) {

                $chronologies = $tool->getToolsChronology();

                $busy = false;

                foreach ($chronologies as $chronology)
                {
                    //change busy status
                    if (!$chronology->getToDate()) {
                        $busy = true;
                        break;
                    }
                }

                //check if tools is deleted
                if(!$uow->isScheduledForDelete($tool)) {
                    $tool->setBusy($busy);

                    // persist changes
                    $uow->recomputeSingleEntityChangeSet($em->getClassMetadata('MainBundle:Tools'), $tool);
                }

            }
        }
    }
}

