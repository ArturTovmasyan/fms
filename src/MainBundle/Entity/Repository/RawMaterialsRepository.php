<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class RawMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class RawMaterialsRepository extends EntityRepository
{
    /**
     * @param $ids
     * @return array
     */
    public function findById($ids)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT rm.size, rm.actualCost
                                FROM MainBundle:RawMaterials rm
                                WHERE rm.id in (:ids)
                           ")
            ->setParameter('ids', $ids)
            ->getResult();

        return $result;
    }
}
