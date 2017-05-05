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
            ->createQuery("SELECT t.rate as rate
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
     * This function is used to get all rates
     *
     * @return array
     */
    public function findAllRateInTariff()
    {
        $result = $this->getEntityManager()
            ->createQuery("SELECT t.rate as rate
                            FROM MainBundle:Tariff t
                            GROUP BY rate
                            ORDER BY rate DESC
                           ")
            ->getResult();

        //filter array get rate
        $result = array_map(function ($item) {
            return $item['rate'];
        }, $result);

        return $result;
    }
}
