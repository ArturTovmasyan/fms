<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductComponentAdmin extends Admin
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
            ->add('name')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('productRouteCard', 'route_card_type')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
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
        $productRouteCards = $object->getProductRouteCard();

        if($productRouteCards) {

            foreach($productRouteCards as $productRouteCard)
            {
                if(!$productRouteCards->contains($object))
                {
                    $productRouteCard->setProductComponent($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        // add productRawExpenses
        $productRouteCards = $object->getProductRouteCard();

        //get removed products in Equipment
        $removed = $productRouteCards->getDeleteDiff();

        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //get entity manager
        $em = $container->get('doctrine')->getEntityManager();

        //removed raw expense
        if($removed) {
            foreach ($removed as $remove) {
                $em->remove($remove);
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