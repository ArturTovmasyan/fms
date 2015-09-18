<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Product;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('description','textarea')
            ->add('gost')
            ->add('certificate')
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('getStringWorkshop', null, array('label' => 'workshop'))
            ->add('weight')
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('image')
            ->add('sketch')
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('mould', null, array('label' => 'mould'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get subject
        $subject = $this->getSubject();

        $formMapper
            ->add('name')
            ->add('client')
            ->add('description','textarea', array('required' => false))
            ->add('gost');

        if($subject->getCountInWarehouse() == 0) {
            $formMapper
                ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'));
        }

        if($subject->getGeneralCount() == 0) {
            $formMapper
                ->add('generalCount', null, array('label' => 'general_count'));
        }

        $formMapper
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('size', 'choice', array('choices'=> array(
                    Product::kg =>'kg',
                Product::meters =>'meters',
                Product::counts =>'counts',
                Product::complects =>'complects')))

            ->add('workshop', 'choice', array('label' => 'workshop', 'choices' => array(
                Product::rubber =>'rubber',
                Product::manual =>'manual',
                Product::together =>'together')))
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('sketch', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('certificate', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('weight')
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('mould', null, array('label' => 'mould'))
        ;

    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('client')
            ->add('gost')
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('equipment', null, array('label' => 'equipment', 'mapped' => true))
            ->add('mould', null, array('label'=>'mould', 'mapped'=>true))
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('client')
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('description','textarea')
            ->add('gost')
            ->add('certificate')
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('getStringWorkshop', null, array('label' => 'workshop'))
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('sketch', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('weight')
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('mould', null, array('label' => 'mould'))
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