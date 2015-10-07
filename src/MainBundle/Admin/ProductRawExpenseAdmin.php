<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Product;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductRawExpenseAdmin extends Admin
{
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
//        $productId = $this->getDatagrid()->getResults()[0]->getProduct()->getId();

        //get product id for edit
//        $editProductId = $this->getSubject()? $this->getSubject()->getProduct()? $this->getSubject()->getProduct()->getId() : null : null;

        $formMapper
        ->add('rawMaterials', null, array()
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
        );

        $formMapper
            ->add('count')
        ;
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