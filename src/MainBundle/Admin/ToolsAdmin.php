<?php

namespace MainBundle\Admin;

use MainBundle\Form\ToolsChronologytType;
use MainBundle\Form\ToolsRepairJobType;
use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ToolsAdmin extends Admin
{
    use FmsAdmin;
    const imageClassName = 'ToolImages';

    //set fields option
    protected $formOptions = [
        'cascade_validation' => true
    ];

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
        $query->addSelect('v, pw, im');
        $query->leftJoin($query->getRootAlias() . '.vendors', 'v');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
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
                return 'MainBundle:Admin/Edit:tools_edit.html.twig';
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
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('code')
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('created', 'date', ['widget' => 'single_text'])
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get object id
        $id = $this->getSubject() ? $this->getSubject()->getId() : null;

        //get current class name
        $className = $this->getClassnameLabel();

        $formMapper
            ->add('name', null, ['attr'=>['class' => $className.' '. self::imageClassName]])
            ->add('category', null, ['required' => false])
            ->add('vendors')
            ->add('newVendors', 'text', ['mapped'=>false, 'label'=>'add_vendor', 'required'=>false,
                'attr' => ['placeholder'=> 'add_vendor']])
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('description', 'textarea', ['required'=>false])
            ->add('code')
            ->add('size', 'choice', ['label' => 'size', 'required'=>false, 'choices' => [
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր"]])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id])
            ->end()
            ->with('tools_repair_job')
            ->add('toolsRepairJob', 'collection', ['required'=>false, 'label'=>false,
                'type' => new ToolsRepairJobType(),
                'allow_add'=>true, 'allow_delete'=>true])
            ->end()
            ->with('tools_chronology')
            ->add('toolsChronology', 'collection', ['required'=>false, 'label'=>false,
                'type' => new ToolsChronologytType(),
                'allow_add'=>true, 'allow_delete'=>true])
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('code')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('description')
            ->add('category')
            ->add('vendors')
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('code')
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('free', null, ['label' => 'tools_status'])
            ->add('toolsChronology', null, ['template' => 'MainBundle:Admin/List:tools_chronology_list.html.twig', 'label'=>'tools_chronology'])
            ->add('toolsRepairJob', null, ['template' => 'MainBundle:Admin/List:tools_repair_list.html.twig', 'label'=>'tools_repair_job'])
            ->add('getToolImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
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

        $this->addNewVendor($object);
        $this->setRelations($object);

    }

    /**
     * @param $object
     */
    private function setRelations($object)
    {
        //get tools chronology
        $toolsChronology = $object->getToolsChronology();

        if($toolsChronology) {

            foreach($toolsChronology as $chronology)
            {
                if(!$chronology->getId()) {
                    $chronology->setTool($object);
                }
            }
        }

        //get tools repair job
        $toolsRepairJob = $object->getToolsRepairJob();

        if($toolsRepairJob) {

            foreach($toolsRepairJob as $repairJob)
            {
                if(!$repairJob->getId()) {
                    $repairJob->setTool($object);
                }
            }
        }
    }

    /**
     * @param $object
     */
    public function removeRelations($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $container->get('doctrine')->getManager();

        //get tools chronology
        $toolsChronology = $object->getToolsChronology();

        if($toolsChronology) {

            $chronologies = $toolsChronology->getDeleteDiff();

            foreach($chronologies as $chronologe)
            {
                $em->remove($chronologe);
            }
        }

        //get tools repair job
        $toolsRepairJob = $object->getToolsRepairJob();

        if($toolsRepairJob) {

            $repairJobs = $toolsRepairJob->getDeleteDiff();

            foreach($repairJobs as $job)
            {
               $em->remove($job);
            }
        }
    }
}

