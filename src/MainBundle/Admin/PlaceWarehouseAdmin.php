<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PlaceWarehouseAdmin extends Admin
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
        $query->addSelect('m, p, rm');
        $query->leftJoin($query->getRootAlias() . '.mould', 'm');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.rawMaterials', 'rm');
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
            ->add('id')
            ->add('name')
            ->add('warehouse')
            ->add('mould')
            ->add('rawMaterials', null, array('label' => 'raw_materials'))
            ->add('product')
            ->add('sparePart', null, array('label' => 'spare_parts'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('warehouse')
            ->add('mould')
            ->add('product')
            ->add('rawMaterials')
            ->add('prepackMaterials', null, ['label' => 'prepack_materials'])
            ->add('sparePart', null, array('label' => 'spare_parts'))
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
            ->add('warehouse')
            ->add('mould')
            ->add('product')
            ->add('prepackMaterials', null, array('label' => 'prepack_materials'))
            ->add('rawMaterials', null, array('label' => 'raw_materials'))
            ->add('sparePart', null, array('label' => 'spare_parts'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    public function setRelations($object)
    {
        //get raw materials
        $rawMaterials = $object->getRawMaterials();

        if($rawMaterials) {

            foreach($rawMaterials as $rawMaterial)
            {
                $placeRawMaterials = $rawMaterial->getPlaceWarehouse();

                if(!$placeRawMaterials->contains($object))
                {
                    $rawMaterial->addPlaceWarehouse($object);
                }
            }
        }


        //get products
        $products = $object->getProduct();

        if($products) {

            foreach($products as $product)
            {
                $productPlaces = $product->getPlaceWarehouse();

                if(!$productPlaces->contains($object))
                {
                    $product->addPlaceWarehouse($object);
                }
            }
        }


        //get moulds
        $moulds = $object->getMould();

        if($moulds) {

            foreach($moulds as $mould)
            {
                $placeMould = $mould->getPlaceWarehouse();

                if(!$placeMould->contains($object))
                {
                    $mould->addPlaceWarehouse($object);
                }
            }
        }

        //get spareParts
        $spareParts = $object->getSparePart();

        if($spareParts) {

            foreach($spareParts as $sparePart)
            {
                $sparePlace = $sparePart->getPlaceWarehouse();

                if(!$sparePlace->contains($object))
                {
                    $sparePart->addPlaceWarehouse($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        //get products
        $rawMaterials = $object->getRawMaterials();

        //get products
        $products = $object->getProduct();

        //get moulds
        $moulds = $object->getMould();

        //get prepack
        $prepacks = $object->getPrepackMaterials();

        //get spareParts
        $spareParts = $object->getSparePart();

        //get removed rawMaterials in placeWarehouse
        $removedMaterials = $rawMaterials->getDeleteDiff();

        //get removed products in placeWarehouse
        $removedProducts = $products->getDeleteDiff();

        //get removed mould in placeWarehouse
        $removedMoulds = $moulds->getDeleteDiff();

        //get removed spareParts in placeWarehouse
        $removedSpareParts = $spareParts->getDeleteDiff();

        if($removedMaterials) {
            foreach($removedMaterials as $removedMaterial)
            {
                $removedMaterial->removePlaceWarehouse($object);
            }
        }

        if($removedProducts) {
            foreach($removedProducts as $removedProduct)
            {
                $removedProduct->removePlaceWarehouse($object);
            }
        }

        if($removedMoulds) {
            foreach($removedMoulds as $removedMould)
            {
                $removedMould->removePlaceWarehouse($object);
            }
        }

        if($removedSpareParts) {
            foreach($removedSpareParts as $removedSparePart)
            {
                $removedSparePart->removePlaceWarehouse($object);
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