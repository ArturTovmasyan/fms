<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class MetalMaterialsRepository
 * @package MainBundle\Entity\Repository
 */
class MetalMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT mm, im
                            FROM MainBundle:MetalMaterials mm
                            LEFT JOIN mm.images im
                            WHERE mm.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
