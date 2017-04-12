<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10/20/15
 * Time: 6:04 PM
 */

namespace MainBundle\Form\Type;
use MainBundle\Form\ComponentType;
use MainBundle\Form\RouteCardType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductComponentType extends AbstractType
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
        $resolver->setDefaults([
            'type' => new ComponentType(),
            'allow_add' => true,
            'allow_delete' => true,
        ]);
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'component_type';
    }
}