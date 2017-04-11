<?php

namespace MainBundle\Admin;

use MainBundle\Form\ProductRawExpenseType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
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
        /** @noinspection PhpUndefinedMethodInspection */
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
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin/Edit:product_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
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
//            ->add('getSumRawExpense', null, array('label' => 'raw_expense'))
//            ->add('getSumRouteCard', null, array('label' => 'route_card'))
            ->add('description','textarea')
            ->add('gost')
            ->add('generalCount', null, array('label' => 'general_count'))
            ->add('purposeList', null, array('label' => 'Purpose'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('workshop', null, array('label' => 'workshop'))
            ->add('weight')
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
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

        $mouldIds = [];

        $moulds = $this->getSubject()->getMould();

        foreach ($moulds as $mould)
        {
            $mouldIds[] = $mould->getId();
        }

        $formMapper
            ->add('name')
            ->add('client')
            ->add('equipment', null, array(
                'label' => 'equipment',
                'query_builder' => function($query)  {
                    $result = $query->createQueryBuilder('p');
                        $result
                            ->select('eq')
                            ->from('MainBundle:Equipment','eq')
                            ->leftJoin('eq.product', 'ep')
                            ->where('eq.type = :type')
                            ->setParameter(':type', 1);

                    return $result;
                }
            ))
            ->add('mould', null, array(
                'label' => 'mould',
                'query_builder' => function($query) use ($editProductId, $mouldIds) {
                    $result = $query->createQueryBuilder('p');
                        $result
                            ->select('m')
                            ->from('MainBundle:Mould', 'm')
                            ->leftJoin('m.product', 'mp')
                            ->groupBy('m.id')
                            ->where('mp.id is null')
                            ->having('COUNT(mp.id) < m.mouldType');
                    if($editProductId) {

                        $result->resetDqlPart('having');

                        $result
                            ->orWhere('m.id IN (:ids)')
                            ->setParameter(':ids', $mouldIds);
                    }

                    return $result;
                }
            ))
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
            ->add('workshop', 'sonata_type_model', array('label' => 'workshop', 'required'=>false))
            ->add('weight')

            ->end();

//            ->with('operationCard')

//            ->add('productRawExpense', 'collection', ['label'=>'product_expense', 'type' => new ProductRawExpenseType(),
//                'allow_add'=>true, 'allow_delete'=>true])

//            ->add('productRawExpense', 'sonata_type_collection', array(
//                'label' => 'product_expense',
//                'by_reference' => true,
//                'required' => false,
//                'mapped'=>true,
//                'type_options' => array(
//                    'delete' => false)
//                ),
//                array(
//                    'edit' => 'inline',
//                    'inline' => 'table'
//                ))

//            ->add('productComponent', 'component_type')
//            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['show_filter' => true])
            ->add('gost')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['label'=>'code', 'template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
//            ->addIdentifier('getSumRawExpense', null, array('label' => 'raw_expense'))
//            ->addIdentifier('getSumRouteCard', null, array('label' => 'route_card'))
            ->add('client')
            ->add('gost')
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('workshop', null, array('label' => 'workshop'))
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
        $em = $container->get('doctrine')->getManager();

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

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->setRelations($object);
        $this->preUpdate($object);

    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
//        $this->updateComponents($object);
        $this->setRelations($object);
        $this->removeRelations($object);
    }


}