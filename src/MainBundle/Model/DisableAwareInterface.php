<?php

namespace MainBundle\Model;

/**
 * Interface DisableAwareInterface
 * @package MainBundle\Model
 */
interface DisableAwareInterface
{
    /**
     * @param $disabled
     * @return mixed
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

}