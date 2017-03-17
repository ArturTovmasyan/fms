<?php

namespace MainBundle\Form\Type;

use MainBundle\Form\SparePartImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SparePartMultipleFileType
 * @package MainBundle\Form\Type
 */

class SparePartMultipleFileType extends AbstractType
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
            'type' => new SparePartImageType(),
            'allow_add' => true,
            'allow_delete' => true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'spare_part_multiple_file';
    }
}