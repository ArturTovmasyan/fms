<?php

namespace MainBundle\Twig\Extension;

/**
 * Class ImageFilterExtension
 * @package MainBundle\Twig\Extension
 */
class ImageFilterExtension extends \Twig_Extension
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

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('fmsImageFilter', array($this, 'fmsImageFilter')),
        );
    }


    /**
     * @param $path
     * @param $filter
     */
    public function fmsImageFilter($path, $filter)
    {
        // check has http in path
        if(strpos($path, 'http') === false){

            try{
                $request = $this->container->get('request_stack')->getCurrentRequest();
                $this->container->get('liip_imagine.controller')->filterAction($request, $path, $filter);
                $cacheManager = $this->container->get('liip_imagine.cache.manager');
                $srcPath = $cacheManager->getBrowserPath($path, $filter);

                return $srcPath;
            }catch (\Exception $e){
                return $path;
            }
        }
        else{
            return $path;
        }
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'app_fms_image_filter';
    }
}