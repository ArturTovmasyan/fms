<?php

namespace MainBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class VisibilityFilter
 * @package MainBundle\Filter
 */
class VisibilityFilter extends SQLFilter
{
    /**
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     * @return string
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // check publish
        if ($targetEntity->reflClass->implementsInterface('MainBundle\Model\DisableAwareInterface')) {

            return $targetTableAlias.'.disabled = 0' ;
        }

        return "";
    }
}