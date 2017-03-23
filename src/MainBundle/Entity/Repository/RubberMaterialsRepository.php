<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class RubberMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class RubberMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT rb, im
                            FROM MainBundle:RubberMaterials rb
                            LEFT JOIN rb.images im
                            WHERE rb.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
