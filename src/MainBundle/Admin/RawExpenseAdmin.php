<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Product;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RawExpenseAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
//            ->add('rawMaterial')
            ->add('size')
            ->add('count')
            ->add('cost')
            ->add('price')
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('rawMaterial')
            ->add('size')
            ->add('count')
            ->add('cost')
//            ->add('price')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
//            ->add('rawMaterial')
            ->add('size')
            ->add('count')
            ->add('cost')
            ->add('price')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
//            ->add('rawMaterial')
            ->add('size')
            ->add('count')
            ->add('cost')
            ->add('price')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    //set rawMaterial in rawExpense
    public function setPriceData($object)
    {
        //get count
        $count = $object->getCount();

        //get cost
        $cost = $object->getCost();

        //get price
        $price = $count*$cost;

        //set price
        $object->setPrice($price);
    }

    public function preUpdate($object)
    {
        $this->setPriceData($object);
    }

    public function prePersist($object)
    {
        $this->setPriceData($object);
    }

}