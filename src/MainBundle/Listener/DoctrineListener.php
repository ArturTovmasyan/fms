<?php

namespace MainBundle\Listener;

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

    protected $histories = null;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        //get data
        $entity = $args->getObject();
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        // check entity
        if($entity instanceof Personnel){

            if ($args->hasChangedField('post')) {

                $post = $entity->getPost();

                if($post) {

                    $history = new PostHistory();
                    $history->setPost($post);
                    $history->setPersonnel($entity);

                    $this->histories = $history;
                }
            }
        }

        // check entity
        if($entity instanceof Post){

            if ($args->hasChangedField('personnel')) {

                $personnel = $entity->getPersonnel();

                if($personnel) {

                    $history = new PostHistory();
                    $history->setPost($entity);
                    $history->setPersonnel($personnel);

                    $this->histories = $history;
                }
            }
        }
    }

    /**
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event)
    {
        //get history
        $history = $this->histories;

        if(!empty($history)) {

            $em = $event->getEntityManager();
            $em->persist($history);

            $this->histories = null;
            $em->flush();
        }
    }

    /**
     * This function is used to automatically generate post history
     */
    private function generatePostHostory()
    {
    }
}

