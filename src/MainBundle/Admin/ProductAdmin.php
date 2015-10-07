<?php

namespace MainBundle\Admin;

use Doctrine\ORM\Query;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
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
        $query->addSelect('m, e, c, pw, pl, pre, rm');
        $query->leftJoin($query->getRootAlias() . '.mould', 'm');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'e');
        $query->leftJoin($query->getRootAlias() . '.client', 'c');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.purposeList', 'pl');
        $query->leftJoin($query->getRootAlias() . '.productRawExpense', 'pre');
        $query->leftJoin('pre.rawMaterials', 'rm');
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
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('getSumRawExpense', null, array('label' => 'raw_expense'))
            ->add('productRawExpense')
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

        $formMapper
            ->add('name')
            ->add('productRawExpense', 'sonata_type_collection', array(
                'label' => 'product_expense',
                'by_reference' => false,
                'mapped'   => true,
                'required' => true),
                array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
            ->add('client')
            ->add('description','textarea', array('required' => false))
            ->add('gost')
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('size', 'choice', array('choices'=> array(
                'Կգ',
                'Մետր',
                'Հատ',
                'Կոմպլեկտ',
                'Լիտր')))
            ->add('workshop', 'choice', array('label' => 'workshop', 'choices' => array(
                'Ռեզինե',
                'Մեխանիկական',
                'Համատեղ')))
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('sketch', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('certificate', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.file', 'context' => 'default')))
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
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('getSumRawExpense', null, array('label' => 'raw_expense'))
            ->add('productRawExpense')
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
            ->add('created', 'date', array('widget' => 'single_text'))
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
    public function setRelations($object)
    {
        // add productRawExpenses
        $productRawExpenses = $object->getProductRawExpense();

        if($productRawExpenses) {
            foreach($productRawExpenses as $productRawExpense)
            {

                if(!$productRawExpenses->contains($object))
                {
                    $productRawExpense->setProduct($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        // add productRawExpenses
        $productRawExpenses = $object->getProductRawExpense();

        //get removed products in Equipment
        $removed = $productRawExpenses->getDeleteDiff();

        if($removed) {
            foreach ($removed as $remove) {
                $remove->setProduct(null);
            }
        }

    }

    public function preUpdate($object)
    {
        $this->setRelations($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
        $this->setRelations($object);
    }
}