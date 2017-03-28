<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PostRepository
 * @package MainBundle\Entity\Repository
 */
class PostRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT p, im
                            FROM MainBundle:Post p
                            LEFT JOIN p.images im
                            WHERE p.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
