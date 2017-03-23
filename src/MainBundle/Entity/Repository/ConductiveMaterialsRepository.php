<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class ConductiveMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class ConductiveMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT cm, im
                            FROM MainBundle:ConductiveMaterials cm
                            LEFT JOIN cm.images im
                            WHERE cm.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
