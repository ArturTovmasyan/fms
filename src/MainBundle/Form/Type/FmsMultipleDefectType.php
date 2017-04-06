<?php

namespace MainBundle\Form\Type;

use MainBundle\Form\EquipmentDefectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FmsMultipleDefectType
 * @package MainBundle\Form\Type
 */
class FmsMultipleDefectType extends AbstractType
{
    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'type' => new EquipmentDefectType(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fms_eq_defects';
    }
}