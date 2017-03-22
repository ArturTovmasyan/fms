<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SparePartRepository
 * @package MainBundle\Entity\Repository
 */
class SparePartRepository extends EntityRepository
{
    /**
     * @param $className
     * @param $id
     * @return array
     */
    public function findFiles($className, $id)
    {
        $class = 'MainBundle:'.$className;

        return $this->getEntityManager()
             ->createQuery("SELECT im.id, im.fileName, im.fileSize, im.fileOriginalName
                            FROM $class dt
                            LEFT JOIN dt.images im
                            WHERE dt.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();
    }
}
