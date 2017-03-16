<?php

namespace MainBundle\Form\Type;

use MainBundle\Form\EquipmentImageType;
use MainBundle\Form\MaterialImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MaterialMultipleFileType
 * @package MainBundle\Form\Type
 */
class MaterialMultipleFileType extends AbstractType
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
            'type' => new MaterialImageType(),
            'allow_add' => true,
            'allow_delete' => true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'material_multiple_file';
    }
}