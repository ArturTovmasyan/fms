<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PrepackMaterialsAdmin extends Admin
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
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');

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
            ->add('vendors')
            ->add('description')
            ->add('code')
            ->add('getStringWorkshop', null, array('label' => 'workshop'))
            ->add('product')
            ->add('equipment')
            ->add('weight')
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('created', 'date', array('widget' => 'single_text'));
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('vendors')
            ->add('description')
            ->add('code')
            ->add('workshop', 'choice', array('choices'=> array(
                "Ռետինատեխնիկական",
                "Մետաղամշակման",
                "Լաբորատորիա",
                "Այլ")))
            ->add('product')
            ->add('equipment')
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('weight')
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
            ->add('id', null, array('show_filters' => true))
            ->add('name', null, array('show_filters' => true))
            ->add('code', null, array('show_filters' => true))
            ->add('weight', null, array('show_filters' => true))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('vendors')
            ->add('description')
            ->add('code')
            ->add('getStringWorkshop', null, array('label' => 'workshop'))
            ->add('product')
            ->add('equipment')
            ->add('weight')
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('getStringSize', null, array('label' => 'size'))
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

