<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10/20/15
 * Time: 6:06 PM
 */

namespace MainBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class RouteCardType
 * @package MainBundle\Form
 */
class RouteCardType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('routeCardPrice', null, array('attr' => array(
                'readonly' => true,
                'disabled' => true)));
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\ProductRouteCard'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'main_bundle_product_route_card';
    }
}