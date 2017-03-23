<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ToolsRepository
 * @package MainBundle\Entity\Repository
 */
class ToolsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT t, im
                            FROM MainBundle:Tools t
                            LEFT JOIN t.images im
                            WHERE t.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
