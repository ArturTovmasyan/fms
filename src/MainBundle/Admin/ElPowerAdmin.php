<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ElPowerAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'el_power';

    //hide remove and edit buttons
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('value', null, ['label'=>'el_power_value'])
            ->add('text', null, ['label'=>'description'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('value', null, ['label'=>'el_power_value'])
            ->add('text', null, ['label'=>'description'])
            ->add('equipment')
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
            ->add('value', null, ['label'=>'el_power_value'])
            ->add('text', null, ['label'=>'description'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('value', null, ['label'=>'el_power_value'])
            ->add('text', null, ['label'=>'description'])
        ;
    }
}
