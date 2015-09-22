<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Product;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipmentAdmin extends Admin
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
            ->add('code')
            ->add('getStringWorkshop', null, array('label' => 'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'State'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('getStringDeployment', null, array('label' => 'deployment'))
            ->add('spares')
            ->add('image')
            ->add('chronologyFile')
            ->add('technicalFile')
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod')
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('code')
            ->add('state','choice', array('choices'=> array(
                "Սարքին` բարվոք վիճակում",
                "Աշխատող` վերանորոգման ենթակա",
                "Չաշխատող` վերանորոգման ենթակա",
                "Անհուսալի")))
            ->add('workshop', 'choice', array('choices'=> array(
                "Ռետինատեխնիկական",
                "Մետաղամշակման",
                "Լաբորատորիա",
                "Այլ")))
            ->add('deployment', 'choice', array('label' => 'deployment', 'choices'=> array(
                "BNGO",
                "KVARTAL",
                "CHERMUSHKA",
                "ERORDMAS")))
//            ->add('mould')// dinamic show by workshop selected data
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('spares')
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('chronologyFile', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('technicalFile', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod')
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('code')
            ->add('name')
            ->add('product')
            ->add('spares')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('getStringWorkshop', null, array('label'=>'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'state'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('getStringDeployment')
            ->add('spares')
            ->add('image', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('chronologyFile', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('technicalFile', 'sonata_type_model_list',
                array('required' => false),
                array('link_parameters' => array('provider' => 'sonata.media.provider.image', 'context'  => 'default')))
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod')
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    //set relations for Equipment
    public function setRelations($object)
    {
        // add products
        $products = $object->getProduct();
        foreach($products as $product)
        {
            $productEquipment = $product->getEquipment();

            if(!$productEquipment->contains($object))
            {
                $product->addEquipment($object);
            }
        }

        // add spares
        $spares = $object->getSpares();
        foreach($spares as $spare)
        {
            if(!$spares->contains($object))
            {
                $spare->setEquipment($object);
            }
        }

    }

    public function removeRelations($object)
    {
        $products = $object->getProduct();

        //get removed products in Equipment
        $removed = $products->getDeleteDiff();

        foreach($removed as $remove)
        {
            $remove->removeEquipment($object);
        }

        // add spares
        $spares = $object->getSpares();
        $removedSpares = $spares->getDeleteDiff();

        foreach($removedSpares as $removedSpare)
        {
            $removedSpare->setEquipment(null);
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
