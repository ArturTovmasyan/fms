<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\Repository\ProfessionsRepository")
 */
class Professions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Tariff", mappedBy="profession", cascade={"persist"}, orphanRemoval=true)
     */
    protected $tariff;

    /**
     * @ORM\OneToMany(targetEntity="RouteCard", mappedBy="profession", cascade={"persist"})
     */
    protected $routeCard;

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->name ? (string)$this->name : '';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Professions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tariff = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tariff
     *
     * @param \MainBundle\Entity\Tariff $tariff
     * @return Professions
     */
    public function addTariff(\MainBundle\Entity\Tariff $tariff)
    {
        $this->tariff[] = $tariff;

        return $this;
    }

    /**
     * Remove tariff
     *
     * @param \MainBundle\Entity\Tariff $tariff
     */
    public function removeTariff(\MainBundle\Entity\Tariff $tariff)
    {
        $this->tariff->removeElement($tariff);
    }

    /**
     * Get tariff
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * Add routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     * @return Professions
     */
    public function addRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $this->routeCard[] = $routeCard;

        return $this;
    }

    /**
     * Remove routeCard
     *
     * @param \MainBundle\Entity\RouteCard $routeCard
     */
    public function removeRouteCard(\MainBundle\Entity\RouteCard $routeCard)
    {
        $this->routeCard->removeElement($routeCard);
    }

    /**
     * Get routeCard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRouteCard()
    {
        return $this->routeCard;
    }

    /**
     * This function is used to get category names
     *
     * @return string
     */
    public function getCategoryNames()
    {
        $tariffs = $this->getTariff();
        $categoryName = '';

        if(count($tariffs) > 0) {
            foreach ($tariffs as $tf)
            {
                $categoryName .= $tf->getProfessionCategory()->getName().', ';
            }
        }

        return $categoryName;
    }
}
