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
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'MainBundle:Admin/List:productRawExpenseList.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

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
            ->add('rawMaterials.size', null, array('template' => 'MainBundle:Admin\Show:stringSizeInShow.html.twig', 'label' => 'size'))
            ->add('count')
            ->add('rawMaterials.actualCost', null, array('label' => 'raw_price'))
            ->add('getProductRawPrice', null, array('label' => 'price'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $request = $this->getRequest();
        $isAjax = $request->request->get('_xml_http_request');
        $subject = $this->getSubject();

////        //get product id
//        $productId = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getId();
////        //get product id for edit
//        $editProductId = $subject ? $subject->getProduct() ? $subject->getProduct()->getId() : null : null;

        $formMapper
            ->add('rawMaterials', null, array(
                'label'=>'raw_materials',
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
            ->add('size', 'number', ['mapped'=>false, 'label'=>'size', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('count')
            ->add('cost', 'number', ['mapped'=>false, 'label'=>'actual_cost', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
        ;

        //get materials actual cost
        $actualCost = $subject && $subject->getRawMaterials() ?
            $subject->getRawMaterials()->getActualCost() : null;


        //check exist materials actual cost
        if($actualCost) {

            //get product raw price
            $productRawPrice = $subject->getProductRawPrice();

            //check exist product raw price
            if($productRawPrice && !$isAjax && $request->getMethod() == 'GET') {

                $formMapper
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
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, array('label' => 'raw_name'))
            ->add('rawMaterials.size', null, array('label' => 'size', 'template' => 'MainBundle:Admin\List:stringSizeInList.html.twig'))
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