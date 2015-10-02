<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProfessionsTariffAdmin extends Admin
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
        $query->addSelect('ps, pc');
        $query->leftJoin($query->getRootAlias() . '.salariesType', 'ps');
        $query->leftJoin('ps.professionCategory', 'pc');
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
            ->add('id')
            ->add('name')
            ->add('salariesType');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('salariesType', 'sonata_type_collection', array(
                'label' => 'salaries_type',
                'by_reference' => false,
                'mapped'   => true,
                'required' => true),
                array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('salariesType.professionCategory.name', null, array('label' => 'profession_category'));
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('salariesType', null, array('label' => 'profession_category'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    public function setRelations($object)
    {
        //get salariesType
        $salariesTypes = $object->getSalariesType();

        foreach($salariesTypes as $salariesType)
        {
            if(!$salariesTypes->contains($object))
            {
                $salariesType->setProfession($object);
            }
        }
    }

    public function preUpdate($object)
    {
        $this->setRelations($object);
    }

    public function prePersist($object)
    {
        $this->setRelations($object);
    }

}