<?php

namespace MainBundle\Admin;

use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SparePartAdmin extends Admin
{
    use FmsAdmin;

    const imageClassName = 'SparePartImages';

    protected $baseRoutePattern = 'spare_part';

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
        $query->addSelect('v, pw, eq, im');
        $query->leftJoin($query->getRootAlias() . '.vendors', 'v');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
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
            ->add('vendors')
            ->add('equipment', null, ['label' => 'related_equipment'])
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
            ->add('vendors')
            ->add('newVendors', 'text', ['mapped'=>false, 'label'=>'add_vendor', 'required'=>false,
                'attr' => ['placeholder'=> 'add_vendor']])
            ->add('equipment', null, [
                'label' => 'related_equipment',
                'query_builder' => function($query)  {
                    $result = $query->createQueryBuilder('sp');
                    $result
                        ->select('eq', 'sps')
                        ->from('MainBundle:Equipment','eq')
                        ->leftJoin('eq.sparePart', 'sps')
                        ->where('eq.type = :type')
                        ->setParameter(':type', 1);

                    return $result;
                }
            ])

            ->add('description', 'textarea')
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('size', 'choice', ['label' => 'size', 'choices' => ["Կգ", "Մետր","Հատ","Կոմպլեկտ", "Լիտր"]])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('vendors.name', null, ['show_filters' => true])
            ->add('equipment.id', null, ['label' => 'equipment', 'show_filters' => true])
            ->add('description', null, ['show_filters' => true])
            ->add('actualCost', null, ['label' => 'actual_cost', 'show_filters' => true])
            ->add('balanceCost', null, ['label' => 'balance_cost', 'show_filters' => true])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('vendors')
            ->add('equipment', null, ['label' => 'equipment'])
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('size', 'choice', ['label' => 'size', 'choices' => [
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր"]])
            ->add('getSparePartImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
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

        //add new vendor
        $this->addNewVendor($object);
        $this->setRelations($object);
    }

    /**
     * @param $object
     */
    private function setRelations($object)
    {
        //get equipment
        $equipments = $object->getEquipment();

        if($equipments) {

            foreach($equipments as $equipment)
            {
                //get spare part by equipment
                $sparePartEquipment = $equipment->getSparePart();

                //check if current spare part not realted with equipment
                if(!$sparePartEquipment->contains($object)) {
                    $equipment->addSparePart($object);
                }
            }
        }
    }

    /**
     * @param $object
     */
    public function removeRelations($object)
    {
        //get equipment
        $equipment = $object->getEquipment();

        //get removed spare part in Equipment
        $removed = $equipment->getDeleteDiff();

        if($removed) {
            foreach($removed as $remove)
            {
                $remove->removeSparePart($object);
            }
        }

    }
}

