<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SparePartRepository
 * @package MainBundle\Entity\Repository
 */
class SparePartRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT sp, im
                            FROM MainBundle:SparePart sp
                            LEFT JOIN sp.images im
                            WHERE sp.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
