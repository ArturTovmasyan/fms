<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class HouseholdMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class HouseholdMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT hm, im
                            FROM MainBundle:HouseholdMaterials hm
                            LEFT JOIN hm.images im
                            WHERE hm.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
