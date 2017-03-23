<?php

namespace MainBundle\Services;

/**
 * Class FmsService
 * @package MainBundle\Services
 */
class FmsService
{
    /**
     * This function is used to upload files object
     *
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

        //set file data
        $object->setType($extension);
        $object->setFileName(md5(microtime()) . '.' . $extension);
        $object->setFileSize($object->getFile()->getClientSize());
        $object->getFile()->move($object->getAbsolutePath(), $object->getFileName());
        $object->setFile(null);
    }
}