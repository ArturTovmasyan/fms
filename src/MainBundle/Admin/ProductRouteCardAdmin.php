<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductRouteCardAdmin extends Admin
{

    //set array value
    public $professionTariff = array();

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        //get entity manager
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();

        //get tariff price for route card
        $this->professionTariff = $em->getRepository('MainBundle:ProductRouteCard')->getRawCardSumByIds();

        $showMapper
            ->add('id')
            ->add('product')
            ->add('productComponent')
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('tariff', null, array('template' => 'MainBundle:Admin:professionTariffPriceShow.html.twig'))
            ->add('routeCardPrice', null, array('template' => 'MainBundle:Admin:routeCardPriceShow.html.twig'))
            ->add('specificPercent')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
//        $productWorkshop = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getWorkshop();

//        $editProductWorkshop = $this->getSubject()? $this->getSubject()->getProduct()? $this->getSubject()->getProduct()->getWorkshop() : null : null;

        $formMapper
            ->add('productComponent')
            ->add('operation')
            ->add('equipment')
            ->add('profession')
            ->add('professionCategory');

        // if product workshop is HAMATEX
//        if(($editProductWorkshop && $editProductWorkshop == 2) || $productWorkshop && $productWorkshop == 2) {
            $formMapper
                ->add('mould');
//        }
        $formMapper
            ->add('operationCode')
            ->add('dependency')
            ->add('jobTime')
            ->add('specificPercent')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('product')
            ->add('productComponent')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        //get entity manager
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();

        //get tariff price for route card
        $this->professionTariff = $em->getRepository('MainBundle:ProductRouteCard')->getRawCardSumByIds();

        $listMapper
            ->add('id')
            ->add('product')
            ->add('productComponent')
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('tariff', null, array('template' => 'MainBundle:Admin:professionTariffPriceList.html.twig'))
            ->add('routeCardPrice', null, array('template' => 'MainBundle:Admin:routeCardPriceList.html.twig'))
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