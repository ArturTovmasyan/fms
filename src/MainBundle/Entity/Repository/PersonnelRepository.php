<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PersonnelRepository
 * @package MainBundle\Entity\Repository
 */
class PersonnelRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT p, im
                            FROM MainBundle:Personnel p
                            LEFT JOIN p.images im
                            WHERE p.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
