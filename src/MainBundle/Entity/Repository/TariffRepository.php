<?php

namespace MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TariffRepository
 * @package MainBundle\Entity\Repository
 */
class TariffRepository extends EntityRepository
{
    /**
     * @param $professionId
     * @param $categoryName
     * @return array
     */
    public function findByCategoryAndProfessionId($professionId, $categoryName)
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT t.hourSalary as tariff
                            FROM MainBundle:Tariff t
                            LEFT JOIN t.professionCategory pc
                            LEFT JOIN t.profession p
                            WHERE p.id = :profId AND pc.name LIKE :catName
                           ")
            ->setParameter('profId', $professionId)
            ->setParameter('catName', '%'.$categoryName.'%')
            ->getOneOrNullResult();

        return $result;
    }

    /**
     * @param $professionIds
     * @return array
     */
    public function findByProfessionIds($professionIds)
    {
//        $result = $this->getEntityManager()
//            ->createQuery("SELECT t.hourSalary as tariff
//                            FROM MainBundle:Professions p
//                            LEFT JOIN t.professionCategory pc
//                            LEFT JOIN t.profession p
//                            WHERE p.id = :profIds
//                           ")
//            ->setParameter('profIds', $professionIds)
//            ->getOneOrNullResult();

//        return $result;
    }
}
