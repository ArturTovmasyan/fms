<?php

namespace MainBundle\Services;

use Symfony\Component\DependencyInjection\Container;


/**
 * Class FmsService
 * @package MainBundle\Services
 */
class FmsService
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected  $container;

    /**
     * @var
     */
    protected $em;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
    }

    /**
     * This function is used to upload files
     *
     */

    /**
     * @param $object
     */
    public function uploadFile(&$object)
    {
        // the file property can be empty if the field is not required
        if (null == $object->getFile())
        {
            return;
        }

        // check file name
        if($object->getFileName()){
            // get file path
            $path = $object->getAbsolutePath() . $object->getFileName();
            // check file
            if(file_exists($path) && is_file($path)){
                // remove file
                unlink($path);
            }
        }

        // get file originalName
        $object->setFileOriginalName($object->getFile()->getClientOriginalName());

        // get file
        $path_parts = pathinfo($object->getFile()->getClientOriginalName());

        // generate filename
        if(!$path_parts['extension']){
            $extension = $object->getFile()->getMimeType();
            $extension = substr($extension ,strpos($extension, '/') + 1);

        }else{
            $extension = $path_parts['extension'];
        }

        $object->setType($extension);

        $object->setFileName(md5(microtime()) . '.' . $extension);

        // set size
        $object->setFileSize($object->getFile()->getClientSize());

        // upload file
        $object->getFile()->move($object->getAbsolutePath(), $object->getFileName());

        // set file to null
        $object->setFile(null);
    }
}