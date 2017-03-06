<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipmentAdmin extends Admin
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
        $query->addSelect('p, pe, s, ml');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.responsiblePersons', 'pe');
        $query->leftJoin($query->getRootAlias() . '.spares', 's');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');
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
            ->add('code')
            ->add('getStringWorkshop', null, array('label' => 'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'State'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('mould')
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('getStringDeployment', null, array('label' => 'deployment'))
            ->add('spares')
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod')
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    protected $time;

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get subject
        $subject = $this->getSubject();

        //get inspection period in database
        $this->time = $subject->getInspectionPeriod();

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
            ->add('mould')// dinamic show by workshop selected data
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('mould')
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('spares')
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('code')
            ->add('name')
            ->add('product')
            ->add('mould')
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
            ->add('product')
            ->add('mould')
            ->add('getStringDeployment')
            ->add('spares')
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

        if($products) {
            foreach($products as $product)
            {
                $productEquipment = $product->getEquipment();

                if(!$productEquipment->contains($object))
                {
                    $product->addEquipment($object);
                }
            }
        }

        // add spares
        $spares = $object->getSpares();

        if($spares) {
            foreach($spares as $spare)
            {
                if(!$spares->contains($object))
                {
                    $spare->setEquipment($object);
                }
            }
        }

        // add moulds
        $moulds = $object->getMould();

        if($moulds) {
            foreach($moulds as $mould)
            {
                $mouldEquipment = $mould->getEquipment();

                if(!$mouldEquipment->contains($object))
                {
                    $mould->addEquipment($object);
                }
            }
        }
    }

    public function removeRelations($object)
    {
        //get products
        $products = $object->getProduct();

        //get removed products in Equipment
        $removed = $products->getDeleteDiff();

        if($removed) {
            foreach($removed as $remove)
            {
                $remove->removeEquipment($object);
            }
        }

        // add spares
        $spares = $object->getSpares();

        if($spares) {

            //check deleted spares
            $removedSpares = $spares->getDeleteDiff();

            if($removedSpares) {
                foreach($removedSpares as $removedSpare)
                {
                    $removedSpare->setEquipment(null);
                }
            }
        }

        // add moulds
        $moulds = $object->getMould();

        if($moulds) {

            //check deleted moulds
            $removedMoulds = $moulds->getDeleteDiff();

            if($removedMoulds) {

                foreach($removedMoulds as $removedMould)
                {
                    $removedMould->removeEquipment($object);
                }
            }
        }
    }

    public function preUpdate($object)
    {
        //get inspection period in form
        $inspectionPeriod = $object->getInspectionPeriod();

        //check date
        if($inspectionPeriod != $this->time) {

            //get current date
            $date = new \DateTime();

            //set inspection next date
            $object->setInspectionNextDate(date_add($date, date_interval_create_from_date_string($inspectionPeriod . 'day')));
        }

        $this->setRelations($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
        $this->setRelations($object);
    }
}
