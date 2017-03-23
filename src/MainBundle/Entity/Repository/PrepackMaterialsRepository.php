<?php

namespace MainBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class PrepackMaterialsRepository
 * @package MainBundle\Entity\Repository\RawMaterials
 */
class PrepackMaterialsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findFiles($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT pm, im
                            FROM MainBundle:PrepackMaterials pm
                            LEFT JOIN pm.images im
                            WHERE pm.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }
}
