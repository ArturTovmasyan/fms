<?php

namespace MainBundle\Form\Type;

use MainBundle\Form\EquipmentImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EqMultipleFileType
 * @package MainBundle\Form\Type
 */
class EqMultipleFileType extends AbstractType
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
            'type' => new EquipmentImageType(),
            'allow_add' => true,
            'allow_delete' => true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eq_multiple_file';
    }
}