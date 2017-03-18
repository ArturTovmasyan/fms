<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class WorkshopTypeRepository
 * @package MainBundle\Entity\Repository
 */
class WorkshopTypeRepository extends EntityRepository
{
    /**
     * @param $workshopId
     * @return array
     */
    public function findByWorkshopId($workshopId)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT wt.id, wt.name
                           FROM MainBundle:WorkshopType wt
                           LEFT JOIN wt.workshop w
                           WHERE w.id = :workshopId
                           ")
            ->setParameter('workshopId', $workshopId)
            ->getResult();
    }
}
