<?php

namespace MainBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    //set fields option
    protected $formOptions = array(
        'cascade_validation' => true
    );

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
        $query->addSelect('m, e, c, pw, pl, pre, pc, rm');
        $query->leftJoin($query->getRootAlias() . '.mould', 'm');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'e');
        $query->leftJoin($query->getRootAlias() . '.client', 'c');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.purposeList', 'pl');
        $query->leftJoin($query->getRootAlias() . '.productRawExpense', 'pre');
        $query->leftJoin($query->getRootAlias() . '.productComponent', 'pc');
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
            ->add('getSumRouteCard', null, array('label' => 'route_card'))
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
        //get product id for edit
        $editProductId = $this->getSubject() ? $this->getSubject() ? $this->getSubject()->getId() : null : null;

        $formMapper
            ->add('name')
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
            ->add('equipment', null, array(
                'label' => 'equipment',
                'query_builder' => function($query) use ($editProductId) {
                    $result = $query->createQueryBuilder('p');
                        if(!$editProductId) {
                            $result
                                ->select('eq')
                                ->from('MainBundle:Equipment','eq')
                                ->leftJoin('eq.product', 'ep')
                                ->where('ep.id is null');
                        }

                    return $result;
                }
            ))
            ->add('mould', null, array(
                'label' => 'mould',
                'query_builder' => function($query) use ($editProductId) {
                    $result = $query->createQueryBuilder('p');
                        if(!$editProductId) {
                            $result
                                ->select('m')
                                ->from('MainBundle:Mould','m')
                                ->leftJoin('m.product', 'mp')
                                ->where('mp.id is null');
                        }

                    return $result;
                }
            ))
            ->end()
            ->with('operationCard')
            ->add('productRawExpense', 'sonata_type_collection', array(
                'label' => 'product_expense',
                'by_reference' => false,
                'mapped' => true,
                'required' => true),
                array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
            ->add('productComponent', 'component_type')
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->add('gost')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'code'))
            ->add('name')
            ->addIdentifier('getSumRawExpense', null, array('label' => 'raw_expense'))
            ->addIdentifier('getSumRouteCard', null, array('label' => 'route_card'))
            ->add('client')
            ->add('gost')
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('getStringWorkshop', null, array('label' => 'workshop'))
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('mould', null, array('label' => 'mould'))
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
        // get product route card
        $productComponents = $object->getProductComponent();

        // if product route card is exist
        if($productComponents) {

            foreach($productComponents as $productComponent)
            {
                if(!$productComponent->getId() || !$productComponents->contains($object)) {
                    $productComponent->setProduct($object);
                }
            }
        }

        // get product raw expenses
        $productRawExpense = $object->getProductRawExpense();

        // if product raw expenses is exist
        if($productRawExpense) {

            foreach($productRawExpense as $productRawExpens)
            {
                if(!$productRawExpens->getId() || !$productRawExpense->contains($object)) {
                    $productRawExpens->setProduct($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        // add productRouteCard
        $productComponents = $object->getProductComponent();

        //get removed products in route card
        $componentRemoved = $productComponents->getDeleteDiff();

        // get productRawExpenses
        $productRawExpense = $object->getProductRawExpense();

        //get delete diff
        $rawExpenseRemoved = $productRawExpense->getDeleteDiff();

        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //get entity manager
        $em = $container->get('doctrine')->getEntityManager();

        //removed product components
        if($componentRemoved) {
            foreach ($componentRemoved as $remove) {
                $em->remove($remove);
            }
        }

        //removed raw expense
        if($rawExpenseRemoved) {
            foreach ($rawExpenseRemoved as $remove) {
                $em->remove($remove);
            }
        }
    }

    /**
     * @param $object
     */
    private function updateComponents($object)
    {
        //get product components
        $components = $object->getProductComponent();

        //if components exist
        if($components){

            foreach($components as $component){

                //get product route cards
                $productCards = $component->getProductRouteCard();

                //if product cards exist
                if($productCards){

                    foreach($productCards as $productCard){

                        //set component in route card
                        $productCard->setProductComponent($component);
                    }
                }
            }
        }
    }

    public function preUpdate($object)
    {
        $this->updateComponents($object);
        $this->setRelations($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
        $this->updateComponents($object);
        $this->setRelations($object);
    }
}