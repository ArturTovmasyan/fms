<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\EqMultipleFileType;
use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipmentAdmin extends Admin
{
    use FmsAdmin;

    const imageClassName = 'EquipmentImage';

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
        $query->addSelect('p, pe, s, ml, im');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.responsiblePersons', 'pe');
        $query->leftJoin($query->getRootAlias() . '.spares', 's');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');

        return $query;
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin:equipment_edit.html.twig';
                break;
            case 'list':
                return 'MainBundle:Admin:equipment_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('equipment-report', $this->getRouterIdParameter().'/equipment-report');
        $collection->add('equipment-filling', 'equipment-filling');
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
            ->add('workshop', null, array('label'=>'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'State'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
            ->add('product')
            ->add('mould')
            ->end()
            ->with('over_size')
            ->add('length', null, ['label'=>'length'])
            ->add('width', null, ['label'=>'width'])
            ->add('height', null, ['label'=>'height'])
            ->end()
            ->add('images', null, ['template' => 'MainBundle:Admin:fms_image_show.html.twig', 'label'=>'files'])
            ->add('type', null, ['label' => 'equipment_type'])
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('spares')
            ->add('elPower', null, ['label'=>'el_power'])
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('weight')
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
            ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text', 'label'=>'inspection_next_date'))
            ->add('created', 'date', array('widget' => 'single_text'))
        ;
    }

    protected $time;

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        //get current class name
        $className = $this->getClassnameLabel();

        //get object id
        $id = $subject ? $subject->getId() : null;

        $moulds = $this->getSubject()->getMould();
        $mouldIds = [];

        foreach ($moulds as $mould)
        {
            $mouldIds[] = $mould->getId();
        }

        //get inspection period in database
        $this->time = $subject->getInspectionPeriod();

        $formMapper
            ->add('name', null, ['attr'=>['class' => $className.' '. self::imageClassName]])
            ->add('code')
            ->add('state', 'choice', array('choices'=> array(
                0 => ' ',
                1 => "Սարքին` բարվոք վիճակում",
                2 => "Աշխատող` վերանորոգման ենթակա",
                3 => "Չաշխատող` վերանորոգման ենթակա",
                4 => "Անհուսալի"), 'required'=>false))
            ->add('workshop', 'sonata_type_model', ['label'=>'equipment_workshop'])
            ->add('type', null, ['attr' => ['class' => 'hidden-field'], 'label'=>false])
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('description')
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date', 'required'=>false))
            ->add('product')
            ->end()
            ->with('over_size')
            ->add('length', null, ['label'=>'length'])
            ->add('width', null, ['label'=>'width'])
            ->add('height', null, ['label'=>'height'])
            ->end()
            ->add('mould', null, array(
                'label' => 'mould',
                'query_builder' => function($query) use ($id, $mouldIds) {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('m', 'mp')
                        ->from('MainBundle:Mould', 'm')
                        ->leftJoin('m.product', 'mp')
                        ->groupBy('m.id')
                        ->where('mp.id is null')
                        ->having('COUNT(mp.id) < m.mouldType');
                    if($id) {
                        $result
                            ->orWhere('m.id IN (:ids)')
                            ->setParameter(':ids', $mouldIds);
                    }

                    return $result;
                }
            ))
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('spares')
            ->add('elPower', null, ['label'=>'el_power'])
            ->add('weight')
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
            ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
            ->add('imageIds', 'hidden', ['mapped'=>false]);

        if($id){
            $formMapper
                ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
        }
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
            ->add('workshop', null, array('label'=>'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'State'))
            ->add('product')
            ->add('mould')
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('type', null, ['label' => 'equipment_type'])
            ->add('spares')
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
            ->add('elPower', null, ['label'=>'el_power'])
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('getEquipmentImages', null, ['template' => 'MainBundle:Admin:fms_image_list.html.twig', 'label'=>'files'])
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
            ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
            ->add('inspectionNextDate', 'date', array('widget'=>'single_text', 'label'=>'inspection_next_date'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'report' => ['template' => 'MainBundle:Admin:equipment_report_action.html.twig']
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

        $this->prePersist($object);
        $this->removeRelations($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        //set image class name
        $imageClassName = self::imageClassName;

        //set relation for object and images
        $images = $this->getImages($imageClassName);
        $this->addImages($object, $images);
    }
}
