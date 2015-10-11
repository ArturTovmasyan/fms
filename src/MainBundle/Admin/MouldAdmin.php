<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MouldAdmin extends Admin
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
        $query->addSelect('p, pw, eq');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
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
            ->add('code', null, array('label' => 'code'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('getStringState', null, array('label' => 'current_state'))
            ->add('preparationTime', 'date', array('widget'=>'single_text', 'label' => 'preparation_time'))
            ->add('lastRepair', 'date', array('label' => 'last_repair', 'widget' => 'single_text'))
            ->add('cost', null, array('label' => 'cost_price'))
            ->add('actualPrice', null, array('label' => 'actual_price'))
            ->add('accountingPrice', null, array('label' => 'accounting_price'))
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('created', 'datetime', array('widget' => 'single_text'))
            ->add('product')
            ->add('bandwidth')
            ->add('mouldType')
            ->add('equipment')
            ->add('repairData', null, array('label' => 'repair_data'))
            ->add('description')
            ->add('image')
            ->add('sketch')
            ->add('weight')
            ->add('overSize', null, array('label' => 'over_size'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('code')
            ->add('product')
            ->add('mouldType')
            ->add('repairData', null, array('label' => 'repair_data'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('description')
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('sketch', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('currentState', 'choice', array('label' => 'current_state', 'choices'=> array(
                "Նորմալ",
                "Վերանորոգման ենթակա",
                "Անպիտան",
                "Ձևափոխված")))
            ->add('bandwidth')
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('preparationTime', 'date', array('widget' => 'single_text', 'label' => 'preparation_time'))
            ->add('lastRepair', 'date', array('label' => 'last_repair', 'widget' => 'single_text'))
            ->add('cost')
            ->add('actualPrice', null, array('label' => 'actual_price'))
            ->add('accountingPrice', null, array('label' => 'accounting_price'))
            ->add('weight')
            ->add('overSize', null, array('label' => 'over_size'))
            ->add('equipment')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'code'))
            ->add('placeWarehouse')
            ->add('mouldType')
            ->add('repairData', null, array('label' => 'repair_data'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('code')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('code')
            ->add('product')
            ->add('mouldType')
            ->add('repairData', null, array('label' => 'repair_data'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('description')
            ->add('getStringState', null, array('label' => 'current_state'))
            ->add('bandwidth')
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('preparationTime', 'date', array('widget' => 'single_text', 'label'=>'preparation_time'))
            ->add('lastRepair', 'date', array('label' => 'last_repair', 'widget' => 'single_text'))
            ->add('images', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('sketch', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context' => 'default')))
            ->add('cost')
            ->add('actualPrice', null, array('label' => 'actual_price'))
            ->add('accountingPrice', null, array('label' => 'accounting_price'))
            ->add('weight')
            ->add('overSize', null, array('label' => 'over_size'))
            ->add('equipment')
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

    public function preUpdate($object)
    {
        //get products
        $products = $object->getProduct();

        if($products) {

            foreach($products as $product)
            {
                $productMoulds = $product->getMould();

                if(!$productMoulds->contains($object))
                {
                    $product->addMould($object);
                }
            }
        }


        //get removed products in mould
        $removed = $products->getDeleteDiff();

        if($removed) {

            foreach($removed as $remove)
            {
                $remove->removeMould($object);
            }
        }
    }

    public function prePersist($object)
    {
        //get products
        $products = $object->getProduct();

        if($products) {

            foreach($products as $product)
            {
                $productMoulds = $product->getMould();

                if(!$productMoulds->contains($object))
                {
                    $product->addMould($object);
                }
            }
        }
    }
}

