<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProfessionsRepository
 * @package MainBundle\Entity\Repository
 */
class ProfessionsRepository extends EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function findCategoryByProfId($id)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT ct.id, ct.name
                            FROM MainBundle:Professions p
                            LEFT JOIN p.tariff t
                            LEFT JOIN t.professionCategory ct
                            WHERE p.id = :id
                           ")
            ->setParameter('id', $id)
            ->getResult();

        return $result;
    }

    /**
     * This function is used to get categories by profession ids
     *
     * @param $professionIds
     * @return array
     */
    public function findByProfessionIds($professionIds)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT p, ct.id, ct.name
                            FROM MainBundle:Professions p
                            LEFT JOIN p.tariff t
                            LEFT JOIN t.professionCategory ct
                            WHERE p.id IN (:profIds)
                           ")
            ->setParameter('profIds', $professionIds)
            ->getArrayResult();

        return $result;
    }
}
