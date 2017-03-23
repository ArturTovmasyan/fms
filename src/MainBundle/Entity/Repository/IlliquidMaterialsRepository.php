<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class IlliquidMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class IlliquidMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT il, im
                            FROM MainBundle:IlliquidMaterials il
                            LEFT JOIN il.images im
                            WHERE il.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
