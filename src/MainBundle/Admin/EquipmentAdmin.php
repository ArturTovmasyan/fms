<?php

namespace MainBundle\Admin;

use MainBundle\Form\EquipmentDefectType;
use MainBundle\Form\EquipmentElPowerType;
use MainBundle\Traits\FmsAdmin;
use MainBundle\Traits\Resource\Equipment;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipmentAdmin extends Admin
{
    use FmsAdmin;
    use Equipment;

    const imageClassName = 'EquipmentImage';
    public $showIds;

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
        $query->addSelect('p, pe, s, ml, im, eqs, elp, rd');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.responsiblePersons', 'pe');
        $query->leftJoin($query->getRootAlias() . '.spares', 's');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');
        $query->leftJoin($query->getRootAlias() . '.eqState', 'eqs');
        $query->leftJoin($query->getRootAlias() . '.elPowers', 'elp');
        $query->leftJoin($query->getRootAlias() . '.removeDefects', 'rd');

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
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->generateShowId();

        $showMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Show:equipment_id_show.html.twig'])
            ->add('name')
            ->add('code')
            ->add('workshop', null, array('label'=>'equipment_workshop'))
            ->add('eqState', null, array('label'=>'equipment_state'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
            ->add('product')
            ->add('mould')
            ->end()
            ->with('remove_defects')
            ->add('removeDefects', null, ['label' => 'remove_defects', 'template' => 'MainBundle:Admin/Show:remove_defects_show.html.twig'])
            ->end()
            ->with('over_size')
            ->add('getOverSize', null, ['label'=>'over_size'])
            ->end()
            ->add('type', null, ['label' => 'equipment_type'])
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('spares')
            ->end()
            ->with('el_power')
            ->add('elPowers', null, ['label'=>'el_power', 'template' => 'MainBundle:Admin/Show:el_power_show.html.twig'])
            ->end()
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('weight')
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
            ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
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
            ->add('workshop', 'sonata_type_model', ['required'=>false, 'btn_add'=>'Ավելացնել արտադրամաս', 'label'=>'equipment_workshop'])
            ->add('type', null,  ['label'=>'equipment_type'])
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('description')
            ->add('repairJob', null, ['label' => 'repair_job'])
            ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date', 'required'=>false))
            ->add('product')
            ->end()
            ->end()
            ->with('remove_defects')
            ->add('removeDefects', 'collection', ['label'=>'remove_defects', 'type' => new EquipmentDefectType(),
                'allow_add'=>true, 'allow_delete'=>true])
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
            ->add('weight')
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
            ->add('inspectionPeriod', null, ['label' => 'inspection_period'])
            ->end()
            ->with('el_power')
            ->add('elPowers', 'collection', ['label'=>false, 'type' => new EquipmentElPowerType(),
                'allow_add'=>true, 'allow_delete'=>true])
            ->end()
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('code')
            ->add('name')
            ->add('spares')
            ->add('type', null,  ['label'=>'equipment_type'])
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('workshop', null, ['label' => 'equipment_workshop'])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $showFields = null;
        $this->generateShowId();

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
                }elseif($field == 'id') {
                    $listMapper->add($field, null, ['label' => 'Id', 'template'=>'MainBundle:Admin/List:equipment_id_list.html.twig']);
                }elseif($field == 'purchaseDate'){
                    $listMapper->add($field, 'date', array('widget'=>'single_text', 'label'=>'purchase_date'));
                }elseif($field == 'inspectionNextDate'){
                    $listMapper->add($field, 'date', array('widget'=>'single_text', 'label'=>'inspection_next_date'));
                }elseif($field == 'responsiblePersons'){
                    $listMapper->add($field, null, ['label'=>'responsible_person']);
                }elseif($field == 'removeDefects'){
                    $listMapper->add($field, 'date', array('label' => 'remove_defects', 'template' => 'MainBundle:Admin/List:remove_defects_list.html.twig'));
                }elseif($field == 'created'){
                    $listMapper->add($field, 'date', array('widget' => 'single_text'));
                }elseif($field == 'length'){
                    $listMapper->add('getOverSize', null, ['label'=>'over_size']);
                }else{
                    $listMapper->add($field);
                }

            }
        } else{
            $listMapper
                ->add('id', null, ['template'=>'MainBundle:Admin/List:equipment_id_list.html.twig'])
                ->add('name', null, ['label'=>'name'])
                ->add('code', null, ['label'=>'code'])
                ->add('workshop', null, array('label'=>'equipment_workshop'))
                ->add('eqState', null, array('label'=>'equipment_state'))
                ->add('product', null, ['label'=>'product'])
                ->add('removeDefects', null, ['label' => 'remove_defects', 'template' => 'MainBundle:Admin/List:remove_defects_list.html.twig'])
                ->add('mould', null, ['label'=>'mould'])
                ->add('description',  null, ['label'=>'description'])
                ->add('deployment', null, ['label' => 'deployment'])
                ->add('type', null, ['label' => 'equipment_type'])
                ->add('spares', null, ['label'=>'code'])
                ->add('responsiblePersons', null, ['label'=>'responsible_person'])
                ->add('purchaseDate', 'date', array('widget'=>'single_text', 'label'=>'purchase_date'))
                ->add('elPowers', null, ['label'=>'el_power'])
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
        $this->setRelations($object);
    }

    /**
     * This function is used to generate show id in equipment
     */
    public function generateShowId()
    {
        //get row number for show id
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $connection = $em->getConnection();
        $sql = "SELECT eq.id, @ROW := @ROW + 1 AS row  FROM equipment as eq 
                JOIN (SELECT @ROW := 0) as r 
                ORDER BY eq.id
                ";

        $query = $connection->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();
        $this->showIds = $results;
    }
}
