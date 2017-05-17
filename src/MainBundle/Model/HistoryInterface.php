<?php
namespace MainBundle\Model;

/**
 * Interface ImageableInterface
 * @package MainBundle\Model
 */
interface HistoryInterface
{
    /**
     * @return mixed
     */
    public function getHistory();

    /**
     * @return mixed
     */
    public function setHistory();
}