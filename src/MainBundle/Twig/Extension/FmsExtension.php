<?php

namespace MainBundle\Twig\Extension;


class FmsExtension extends \Twig_Extension
{
    /**
     * @var
     */
    private $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }


    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('unserialize', [$this, 'unserialize']),
        ];
    }

    /**
     * @param $json
     * @return mixed
     */
    public function unserialize($json)
    {
        return  unserialize($json);
    }


    public function getName()
    {
        return 'fms_extension';
    }
}