<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PostHistoryRepository
 * @package MainBundle\Entity\Repository
 */
class PostHistoryRepository extends EntityRepository
{
    /**
     * @param $postId
     * @param $personnelId
     * @return array
     */
    public function findByPostAndPersonId($postId, $personnelId)
    {
        return $this->getEntityManager()
             ->createQuery("SELECT ph
                            FROM MainBundle:PostHistory ph
                            LEFT JOIN ph.post pt
                            LEFT JOIN ph.personnel pn
                            WHERE pt.id = :postId and pn.id = :personnelId
                           ")
            ->setParameter('postId', $postId)
            ->setParameter('personnelId', $personnelId)
            ->getOneOrNullResult();
    }

    /**
     * @param $postId
     * @return array
     */
    public function findByPostId($postId)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT pt.name as postName, pn.name as persName, ph.fromDate, ph.toDate
                            FROM MainBundle:PostHistory ph
                            LEFT JOIN ph.post pt
                            LEFT JOIN ph.personnel pn
                            WHERE pt.id = :postId
                           ")
            ->setParameter('postId', $postId)
            ->getResult();
    }
}
