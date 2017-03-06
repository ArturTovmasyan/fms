<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductRawExpenseAdmin extends Admin
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
        $query->addSelect('rm');
        $query->leftJoin($query->getRootAlias() . '.rawMaterials', 'rm');
        return $query;

    }

    //hide remove and edit buttons
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
    }

    public $supportsPreviewMode = true;

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, array('label' => 'raw_name'))
            ->add('rawMaterials.size', null, array('template' => 'MainBundle:Admin:stringSizeInShow.html.twig', 'label' => 'size'))
            ->add('count')
            ->add('rawMaterials.actualCost', null, array('label' => 'raw_price'))
            ->add('getProductRawPrice', null, array('label' => 'price'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get product id
//        $productId = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getId();

        //get product id for edit
//        $editProductId = $this->getSubject()? $this->getSubject()->getProduct()? $this->getSubject()->getProduct()->getId() : null : null;

        $formMapper
            ->add('rawMaterials', null, array(
//            'query_builder' => function ($query) use ($productId, $editProductId) {
//                $result = $query->createQueryBuilder('rm');
//                if(!$editProductId){
//                    $result
//                        ->where("rm.id NOT IN (
//                                 SELECT t.id from MainBundle:ProductRawExpense re
//                                 LEFT JOIN re.rawMaterials t
//                                 WHERE re.product = :prodId
//                                 )")
//                        ->setParameter('prodId', $productId);
//                }
//                return $result;}
            ))
            ->add('count')
        ;

        //get materials actual cost
        $actualCost = $this->getSubject() ? $this->getSubject()->getRawMaterials() ?
            $this->getSubject()->getRawMaterials()->getActualCost() : null : null;

        //check exist materials actual cost
        if($actualCost) {

            //get product raw price
            $productRawPrice = $this->getSubject() ? $this->getSubject()->getProductRawPrice() ?
                $this->getSubject()->getProductRawPrice() : null : null;

            //check exist product raw price
            if($productRawPrice) {

                $formMapper
                    ->add('rawMaterials.actualCost', null, array('label' => 'actual_price', 'attr' => array(
                        'readonly' => true,
                        'disabled' => true)))
                    ->add('getProductRawPrice', 'integer', array('label' => 'raw_price', 'attr' => array(
                        'readonly' => true,
                        'disabled' => true)))
                ;
            }
        }
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, array('label' => 'raw_name'))
            ->add('rawMaterials.actualCost', null, array('label' => 'raw_price'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, array('label' => 'raw_name'))
            ->add('rawMaterials.size', null, array('label' => 'size', 'template' => 'MainBundle:Admin:stringSizeInList.html.twig'))
            ->add('count')
            ->add('rawMaterials.actualCost', null, array('label' => 'raw_price'))
            ->add('getProductRawPrice', null, array('label' => 'price'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}