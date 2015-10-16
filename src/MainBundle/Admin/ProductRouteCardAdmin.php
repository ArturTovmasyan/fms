<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductRouteCardAdmin extends Admin
{
    /**
     * override list query
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface */

    public function createQuery($context = 'list')
    {
        // call parent query
        $query = parent::createQuery($context);
        // add selected
        $query->addSelect('eq, pr, prc, ml');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
        $query->leftJoin($query->getRootAlias() . '.profession', 'pr');
        $query->leftJoin($query->getRootAlias() . '.professionCategory', 'prc');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');
        return $query;

    }

    //hide remove and edit buttons
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('tariff', null, array('template' => 'MainBundle:Admin:professionTariffPriceShow.html.twig'))
            ->add('routeCardPrice')
            ->add('specificPercent')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

            //get route card price
//        $routeCardPrice = $this->getSubject() ? $this->getSubject()->getRouteCardPrice() ?
//        $this->getSubject()->getRouteCardPrice() : null : null;

        //get product id
//        $productId = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getId();

        $formMapper
//            ->add('productComponent')
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

//        if($routeCardPrice) {
//            $formMapper
//                ->add('getRouteCardPrice', 'integer', array('label' => 'route_card_price', 'attr' => array(
//                    'readonly' => true,
//                    'disabled' => true)));
//        }
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('profession')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('tariff', null, array('template' => 'MainBundle:Admin:professionTariffPriceList.html.twig'))
            ->add('routeCardPrice')
            ->add('specificPercent')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}