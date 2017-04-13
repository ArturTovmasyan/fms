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
            case 'edit':
                return 'MainBundle:Admin/Edit:productRawExpense_edit.html.twig';
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
        $request = $this->getRequest();
        $productId = $request->query->get('productId');

        // call parent query
        $query = parent::createQuery($context);
        // add selected
        $query->addSelect('rm');
        $query->leftJoin($query->getRootAlias() . '.rawMaterials', 'rm');

        if($productId) {
            $query->leftJoin($query->getRootAlias() . '.product', 'pr');
            $query->where('pr.id = :productId')
                ->setParameter('productId', $productId);
        }

        return $query;

    }

    //hide remove and edit buttons
    protected function configureRoutes(RouteCollection $collection)
    {
//        $collection->remove('delete');
//        $collection->remove('edit');
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
            ->add('product')
            ->add('rawMaterials.name', null, ['label' => 'raw_name'])
            ->add('rawMaterials.size', null, ['template' => 'MainBundle:Admin\Show:stringSizeInShow.html.twig', 'label' => 'size'])
            ->add('count')
            ->add('rawMaterials.actualCost', null, ['label' => 'raw_price'])
            ->add('getProductRawPrice', null, ['label' => 'price'])
            ->add('created', 'date', ['widget' => 'single_text'])
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        $expenseId = $subject ? $subject->getId() : null;
        $productId = $formMapper->getAdmin() && $formMapper->getAdmin()->getParentFieldDescription() ?
                $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getId() : null;

        $formMapper
            ->add('rawMaterials', null, [
                'label'=>'raw_materials', 'required' => false,
                'query_builder' => function ($query) use ($productId, $expenseId) {

                $result = $query->createQueryBuilder('rm');

                if($productId){

                    $result
                        ->where("rm.id NOT IN (
                                 SELECT m.id from MainBundle:ProductRawExpense re
                                 LEFT JOIN re.rawMaterials m
                                 WHERE re.product = :prodId AND (re.id != :expenseId OR :expenseId IS NULL) 
                                 )")
                        ->setParameter('prodId', $productId)
                        ->setParameter('expenseId', $expenseId);
                }

                return $result;}
            ]);

            if(!$productId) {
                $formMapper
                    ->add('product', null, [
//                        'query_builder' => function ($query) use ($expenseId) {
//                            $result = $query->createQueryBuilder('pr');
//                            $result
//                               ->where("pr.id IN (
//                             SELECT p.id from MainBundle:Product p
//                             LEFT JOIN p.productRawExpense re
//                             LEFT JOIN re.rawMaterials rm
//                             WHERE (re.id != :expenseId OR re.id IS NULL))")
//                             ->setParameter('expenseId', $expenseId);
//
//                            return $result;}
                    ]);
            }

            $formMapper
            ->add('size', 'number', ['mapped'=>false, 'label'=>'size', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('count')
            ->add('cost', 'number', ['mapped'=>false, 'label'=>'actual_cost', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('sum', 'number', ['mapped'=>false, 'label'=>'raw_price', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, ['label' => 'raw_name'])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('product')
            ->add('rawMaterials.name', null, ['label' => 'raw_name'])
            ->add('rawMaterials.size', null, ['label' => 'size', 'template' => 'MainBundle:Admin\List:stringSizeInList.html.twig'])
            ->add('count')
            ->add('rawMaterials.actualCost', null, ['label' => 'raw_price'])
            ->add('getProductRawPrice', null, ['label' => 'price'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }
}