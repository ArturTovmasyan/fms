<?php

namespace MainBundle\Admin;

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
        $query->addSelect('m, e, c, pw, pl, pre, prc, rm');
        $query->leftJoin($query->getRootAlias() . '.mould', 'm');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'e');
        $query->leftJoin($query->getRootAlias() . '.client', 'c');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.purposeList', 'pl');
        $query->leftJoin($query->getRootAlias() . '.productRawExpense', 'pre');
        $query->leftJoin($query->getRootAlias() . '.productRouteCard', 'prc');
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
        //check exist product id for edit or create product
        $productId = $this->getSubject()->getId();

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
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('mould', null, array('label' => 'mould'))

            ->end();
        if($productId) {
            $formMapper
                ->with('operationCard')
                ->add('productRawExpense', 'sonata_type_collection', array(
                    'label' => 'product_expense',
                    'by_reference' => false,
                    'mapped'   => true,
                    'required' => true),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table'
                    ))
                ->add('productRouteCard', 'sonata_type_collection', array(
                    'label' => 'product_route_card',
                    'by_reference' => false,
                    'mapped'   => true,
                    'required' => true),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table'
                    ))
                ->end();
        };
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
        $productRouteCards = $object->getProductRouteCard();

        if($productRouteCards) {

            foreach($productRouteCards as $productRouteCard)
            {
                if(!$productRouteCards->contains($object))
                {
                    $productRouteCard->setProduct($object);
                }
            }
        }

        // get productRawExpenses
        $productRawExpense = $object->getProductRawExpense();

        if($productRawExpense) {

            foreach($productRawExpense as $productRawExpens)
            {
                if(!$productRawExpense->contains($object))
                {
                    $productRawExpens->setProduct($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        // add productRouteCard
        $productRouteCards = $object->getProductRouteCard();

        //get removed products in route card
        $routeCardRemoved = $productRouteCards->getDeleteDiff();

        // get productRawExpenses
        $productRawExpense = $object->getProductRawExpense();

        //get delete diff
        $rawExpenseRemoved = $productRawExpense->getDeleteDiff();

        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //get entity manager
        $em = $container->get('doctrine')->getEntityManager();

        //removed raw expense
        if($routeCardRemoved) {
            foreach ($routeCardRemoved as $remove) {
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

    private function getPrice($productCards)
    {
        //get entity manager
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();

        //if product Cards exist
        if($productCards){
            foreach($productCards as $productCard){

                //get profession
                $profession = $productCard->getProfession();

                //get profession category
                $professionCategory = $productCard->getProfessionCategory();

                //get job time
                $jobTime = $productCard->getJobTime();

                //get all salaries type by profession
                $salariesTypeArray = $profession->getSalariesType();

                //get salaries type by profession category id
                $salariesType = $salariesTypeArray[$professionCategory->getId()];

                if($salariesType) {
                    //get hour salary
                    $hourSalary  = $salariesType->getHourSalary();

                    //get route card price
                    $price =  $jobTime * $hourSalary;

                    //set route card price
                    $productCard->setRouteCardPrice($price);
                }
                else {
                    $productCard->setRouteCardPrice(0);
                }
                $em->persist($productCard);

            }
        }
    }

    public function preUpdate($object)
    {
        $this->getPrice($object->getProductRouteCard());
        $this->setRelations($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
        $this->getPrice($object->getProductRouteCard());
        $this->setRelations($object);
    }
}