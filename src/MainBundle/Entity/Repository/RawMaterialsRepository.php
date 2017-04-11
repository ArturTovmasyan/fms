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
     * @param $id
     * @return array
     */
    public function findById($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT rm.size, rm.actualCost
                                FROM MainBundle:RawMaterials rm
                                WHERE rm.id = :id
                           ")
            ->setParameter('id', $id)
            ->getOneOrNullResult();

        return $result;
    }
}
