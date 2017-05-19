<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MeetingAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('status')
            ->add('type')
            ->add('date')
            ->add('place')
            ->add('subject')
            ->add('schedule')
            ->add('member')
            ->add('listen')
            ->add('decided')
            ->add('tasks')
            ->add('chairPerson')
            ->add('secretary')
            ->add('state')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('status')
            ->add('type')
            ->add('date')
            ->add('place')
            ->add('subject')
            ->add('schedule')
            ->add('member')
            ->add('listen')
            ->add('decided')
            ->add('tasks')
            ->add('chairPerson')
            ->add('secretary')
            ->add('state')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('status')
            ->add('type')
            ->add('date', 'sonata_type_date_picker')
            ->add('place')
            ->add('subject')
            ->add('schedule')
            ->add('member')
            ->add('listen')
            ->add('decided')
            ->add('tasks')
            ->add('chairPerson')
            ->add('secretary')
            ->add('state')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('status')
            ->add('type')
            ->add('date')
            ->add('place')
            ->add('subject')
            ->add('schedule')
            ->add('member')
            ->add('listen')
            ->add('decided')
            ->add('tasks')
            ->add('chairPerson')
            ->add('secretary')
            ->add('state')
        ;
    }
}
