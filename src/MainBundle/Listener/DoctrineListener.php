<?php

namespace MainBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use MainBundle\Entity\Personnel;
use MainBundle\Entity\Post;
use MainBundle\Entity\PostHistory;
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
}

