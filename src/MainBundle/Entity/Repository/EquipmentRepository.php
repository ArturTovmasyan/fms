<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class EquipmentRepository
 * @package MainBundle\Entity\Repository
 */
class EquipmentRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllEquipment()
    {
        return $this->getEntityManager()
             ->createQuery("SELECT eq,p,m,rp,im
                            FROM MainBundle:Equipment eq
                            LEFT JOIN eq.product p
                            LEFT JOIN eq.mould m
                            LEFT JOIN eq.responsiblePersons rp
                            LEFT JOIN eq.images im
                           ")
            ->getResult();
    }


}
