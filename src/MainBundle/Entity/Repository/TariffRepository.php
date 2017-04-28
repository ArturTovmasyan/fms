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

}
