<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
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
            ->add('name', null, ['label'=>'component_name'])
            ->add('routeCard', 'sonata_type_collection', [
                'label' => 'route_card_operation',
                'by_reference' => false,
                'required' => false,
                'btn_add' => "Ավելացնել օպերացիյա",
                'type_options' => [
                    'delete' => true]
            ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ])
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
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }


    //set rawMaterial in rawExpense
    public function setRelations($object)
    {
        //get route card
        $routeCards = $object->getRouteCard();

        //if route card exist
        if($routeCards) {

            foreach($routeCards as $routeCard)
            {
                if(!$routeCard->getId()) {
                    $routeCard->setProductComponent($object);
                }
            }
        }
    }


    public function removeRelations($object)
    {
        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //get entity manager
        $em = $container->get('doctrine')->getManager();

        //get route card
        $routeCards = $object->getRouteCard();


        if($routeCards) {

            //get delete diff
            $routeCardsRemoved = $routeCards->getDeleteDiff();

            //removed raw expense
            if($routeCardsRemoved) {
                foreach ($routeCardsRemoved as $remove) {
                    $em->remove($remove);
                }
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->setRelations($object);
        $this->removeRelations($object);
    }

}