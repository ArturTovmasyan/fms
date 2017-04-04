<?php

namespace MainBundle\Admin;

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
        $query->addSelect('p, pe, s, ml, im, eqs');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.responsiblePersons', 'pe');
        $query->leftJoin($query->getRootAlias() . '.spares', 's');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');
        $query->leftJoin($query->getRootAlias() . '.eqState', 'eqs');

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
                return 'MainBundle:Admin/Edit:equipment_edit.html.twig';
                break;
            case 'list':
                return 'MainBundle:Admin/List:equipment_list.html.twig';
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
     * Add some fields from mapped entities; the simplest way;
     * @return array
     */
    public function getExportFields() {

        $fieldsArray = $this->getModelManager()->getExportFields($this->getClass());

        //add custom get string functions for relations
        $fieldsArray[] = 'getOverSize';
        $fieldsArray[] = 'getProductsString';
        $fieldsArray[] = 'getMouldsString';
        $fieldsArray[] = 'getWorkshopString';
        $fieldsArray[] = 'getStateString';
        $fieldsArray[] = 'getDeploymentString';
        $fieldsArray[] = 'getTypeString';
        $fieldsArray[] = 'getPersonString';
        $fieldsArray[] = 'getFilesString';

        return $fieldsArray;
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
            ->add('eqState', null, array('label'=>'equipment_state'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
            ->add('product')
            ->add('mould')
            ->add('removeDefects', null, ['label' => 'remove_defects'])
            ->end()
            ->with('over_size')
            ->add('getOverSize', null, ['label'=>'over_size'])
            ->end()
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
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
            ->add('eqState', 'sonata_type_model', ['label'=>'equipment_state', 'btn_add'=>'Ավելացնել վիճակ', 'required'=>false])
            ->add('workshop', 'sonata_type_model', ['required'=>false, 'label'=>'equipment_workshop'])
            ->add('type', null,  ['label'=>'equipment_type'])
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('description')
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date', 'required'=>false))
            ->add('product')
            ->add('removeDefects', 'textarea', ['label' => 'remove_defects', 'required'=>false])
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
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('code')
            ->add('name')
//            ->add('product')
//            ->add('mould')
            ->add('spares')
            ->add('length', null, ['label'=>'length'])
            ->add('width', null, ['label'=>'width'])
            ->add('height', null, ['label'=>'height'])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $showFields = null;

        //get cookies data
        $cookies = $this->getRequest()->cookies;

        if ($cookies->has('EQUIPMENT_FILTERS')) {
            $showFields = unserialize($cookies->get('EQUIPMENT_FILTERS'));
        }

        //check if cookie data exist
        if ($showFields) {

            foreach ($showFields as $field)
            {
                if($field == 'getEquipmentImages') {
                    $listMapper->add($field, null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'] );
                }elseif($field == 'purchaseDate'){
                    $listMapper->add($field, 'date', array('widget'=>'single_text', 'label'=>'purchase_date'));
                }elseif($field == 'inspectionNextDate'){
                    $listMapper->add($field, 'date', array('widget'=>'single_text', 'label'=>'inspection_next_date'));
                }elseif($field == 'responsiblePersons'){
                    $listMapper->add($field, null, ['label'=>'responsible_person']);
                }
                elseif($field == 'created'){
                    $listMapper->add($field, 'date', array('widget' => 'single_text'));
                }
                else{
                    $listMapper->add($field);
                }
            }
        } else{
            $listMapper
                ->add('id', null, ['label'=>'id'])
                ->add('name', null, ['label'=>'name'])
                ->add('code', null, ['label'=>'code'])
                ->add('workshop', null, array('label'=>'equipment_workshop'))
                ->add('eqState', null, array('label'=>'equipment_state'))
                ->add('product', null, ['label'=>'product'])
                ->add('removeDefects', null, ['label' => 'remove_defects'])
                ->add('mould', null, ['label'=>'mould'])
                ->add('description',  null, ['label'=>'description'])
                ->add('deployment', null, ['label' => 'deployment'])
                ->add('type', null, ['label' => 'equipment_type'])
                ->add('spares', null, ['label'=>'code'])
                ->add('responsiblePersons', null, ['label'=>'responsible_person'])
                ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
                ->add('elPower', null, ['label'=>'el_power'])
                ->add('repairJob', null, ['label' => 'repair_job'])
                ->add('getEquipmentImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
                ->add('getOverSize', null, ['label'=>'over_size'])
                ->add('carryingPrice', null, array('label'=>'balance_cost'))
                ->add('factualPrice', null, array('label'=>'actual_cost'))
                ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
                ->add('inspectionNextDate', 'date', array('widget'=>'single_text', 'label'=>'inspection_next_date'))
                ->add('created', 'date', array('widget' => 'single_text'));
        }

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'report' => ['template' => 'MainBundle:Admin/Action:equipment_report_action.html.twig']
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
