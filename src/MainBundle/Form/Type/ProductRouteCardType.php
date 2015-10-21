<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10/20/15
 * Time: 6:04 PM
 */

namespace MainBundle\Form\Type;
use MainBundle\Form\RouteCardType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductRouteCardType extends AbstractType
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
            'type' => new RouteCardType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'route_card_type';
    }
}