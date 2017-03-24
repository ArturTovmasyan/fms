<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DivisionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('type', null, ['label'=>'division_type'])
            ->add('name')
            ->add('subordination')
            ->add('created')
            ->add('orders')
            ->add('headPosition')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'sonata_type_model', ['label'=>'division_type'])
            ->add('name')
            ->add('subordination')
            ->add('created','sonata_type_date_picker', ['required'=>false])
            ->add('orders')
            ->add('headPosition')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
//            ->add('type', null, ['label'=>'division_type'])
            ->add('name')
            ->add('subordination')
            ->add('created')
            ->add('orders')
            ->add('headPosition')
        ;
    }
}
