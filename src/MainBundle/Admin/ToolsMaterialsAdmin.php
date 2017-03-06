<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ToolsMaterialsAdmin extends Admin
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
        $query->addSelect('v, pw');
        $query->leftJoin($query->getRootAlias() . '.vendors', 'v');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        return $query;
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('description')
            ->add('code')
//            ->add('chronology')
//            ->add('repair')
            ->add('actualCost')
            ->add('balanceCost')
            ->add('technicalFile')
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('image')
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('name')
            ->add('category', null, array('required' => true))
            ->add('vendors')
            ->add('actualCost')
            ->add('balanceCost')
            ->add('description')
            ->add('code')
//            ->add('chronology')
//            ->add('repair')
            ->add('technicalFile', 'sonata_type_model_list',
                array('label' => 'technical_file', 'required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.file', 'context' => 'default')))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('size', 'choice', array('label' => 'size', 'choices' => array(
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր")))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'));
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('code')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('actualCost')
            ->add('balanceCost')
            ->add('description')
            ->add('code')
//            ->add('chronology')
//            ->add('repair')
            ->add('technicalFile')
            ->add('image')
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
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

