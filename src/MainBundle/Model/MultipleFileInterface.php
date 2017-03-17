<?php

namespace MainBundle\Model;

use MainBundle\Entity\RawMaterialImages;

/**
 * Interface MultipleFileInterface
 * @package MainBundle\Model
 */
interface MultipleFileInterface
{
    public function addImage(RawMaterialImages $image);

    public function removeImage(RawMaterialImages $image);

    public function getImages();
}