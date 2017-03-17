<?php

namespace MainBundle\Form\Type;

use MainBundle\Form\ToolImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MaterialMultipleFileType
 * @package MainBundle\Form\Type
 */
class ToolMultipleFile extends AbstractType
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
            'type' => new ToolImageType(),
            'allow_add' => true,
            'allow_delete' => true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'tool_multiple_file';
    }
}