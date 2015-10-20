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
            ->add('equipment', null, array(
//                'query_builder' => function ($query) use ($productId) {
//                    $result = $query->createQueryBuilder('eq');
//                    $result
//                        ->select('eq')
//                        ->leftJoin('eq.product', 'pr')
//                        ->where('pr.id = :productId')
//                        ->setParameter('productId', $productId);
//                    return $result;
//                }
            ))
            ->add('mould', null, array(
//                'query_builder' => function ($query) use ($productId) {
//                    $result = $query->createQueryBuilder('ml');
//                    $result
//                        ->select('ml')
//                        ->leftJoin('ml.product', 'pr')
//                        ->where('pr.id = :productId')
//                        ->setParameter('productId', $productId);
//                    return $result;
//                }
            ))
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime');
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