<?php

namespace MainBundle\Admin;

use Doctrine\ORM\PersistentCollection;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductComponentAdmin extends Admin
{
    //set fields option
    protected $formOptions = [
        'cascade_validation' => true
    ];

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin/Edit:component_edit.html.twig';
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
            ->add('id')
            ->add('name')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get parent fields
        $parentField = $formMapper->getAdmin()->getParentFieldDescription();
        $currentId = $this->getSubject() ? $this->getSubject()->getId() : null;

        if(!$parentField && $currentId) {
            $formMapper
                ->add('product', null, ['label'=>'product']);
        };

        $formMapper
            ->add('name', null, ['label'=>'component_name'])
            ->add('routeCard', 'sonata_type_collection', [
                'label' => 'route_card_operation',
                'required' => false,
                'btn_add' => "Ավելացնել օպերացիյա",
                'type_options' => [
                    'delete' => true]
            ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('product')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('product')
            ->add('name', null, ['label'=>'component_name'])
            ->add('routeCard', null, ['label' => 'route_card_operation'])
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

            if($routeCards instanceof PersistentCollection) {
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