<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonnelAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('birthDate')
            ->add('created')
            ->add('updated')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('birthDate')
            ->add('positionDate')
            ->add('mobilePhone')
            ->add('fixedPhone')
            ->add('alternatePhone')
            ->add('email')
            ->add('carNumber')
            ->add('address')
            ->add('husband')
            ->add('children')
            ->add('parent')
            ->add('sister')
            ->add('brother')
            ->add('education')
            ->add('profession')
            ->add('language')
            ->add('compKnowledge')
            ->add('created')
            ->add('updated')
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
            ->tab('global_info')
            ->add('name')
            ->add('birthDate', 'sonata_type_date_picker', ['required'=>false])
            ->add('positionDate', 'sonata_type_date_picker', ['required'=>false])
            ->add('education')
            ->add('profession')
            ->add('language')
            ->add('compKnowledge')

            ->end()
            ->end()

            ->tab('contact_data')
            ->add('mobilePhone')
            ->add('fixedPhone')
            ->add('alternatePhone')
            ->add('email')
            ->add('carNumber')
            ->add('address')
            ->end()
            ->end()

            ->tab('family_data')
            ->add('husband')
            ->add('children')
            ->add('parent')
            ->add('sister')
            ->add('brother')
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('birthDate')
            ->add('positionDate')
            ->add('mobilePhone')
            ->add('fixedPhone')
            ->add('alternatePhone')
            ->add('email')
            ->add('carNumber')
            ->add('address')
            ->add('husband')
            ->add('children')
            ->add('parent')
            ->add('sister')
            ->add('brother')
            ->add('education')
            ->add('profession')
            ->add('language')
            ->add('compKnowledge')
            ->add('created')
            ->add('updated')
        ;
    }
}
