<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\FmsMultipleFileType;
use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipmentAdmin extends Admin
{
    use FmsAdmin;

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
            ->add('code')
            ->add('getStringWorkshop', null, array('label' => 'equipment_workshop'))
            ->add('getStringState', null, array('label'=>'State'))
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('mould')
            ->add('images', null, ['template' => 'MainBundle:Admin:equipment_image_show.html.twig', 'label'=>'Images'])
            ->add('getTypeString', null, ['label' => 'equipment_type'])
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('spares')
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice', null, array('label'=>'balance_cost'))
            ->add('factualPrice', null, array('label'=>'actual_cost'))
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

        //get product id for edit
        $editMouldId = $this->getSubject() ? $this->getSubject() ? $this->getSubject()->getId() : null : null;

        $moulds = $this->getSubject()->getMould();
        $mouldIds = [];

        foreach ($moulds as $mould)
        {
            $mouldIds[] = $mould->getId();
        }

        //get equipment type
        $type = $subject ? $subject->getEquipmentType() : null;

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
                "Ընդ․ օգտագործման")))

            ->add('type1', 'choice', ['attr' => ["class" => "hidden-field"], 'data' => ($type && $type < 5 ? $type : null),
                'required' => false, 'mapped' => false,
                'label' => 'equipment_type', 'choices'=> array(
                0 => "",
                1 => "Մամլիչ հաստոց (Пресс)",
                2 => "Գրտնակահաստոց",
                3 => "Շնեկ",
                4 => "Կաթսա"
            )])

            ->add('type2', 'choice', ['attr' => ["class" => "hidden-field"], 'data' => ($type && $type > 4 ? $type : null),
                'required' => false, 'mapped' => false,
                'label' => false, 'choices'=> array(
                5 => "Խառատային",
                6 => "Ֆրեզերային",
            )])

            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('description')
            ->add('purchaseDate', 'date', array('widget'=>'single_text'))
            ->add('product')
            ->add('mould', null, array(
                'label' => 'mould',
                'query_builder' => function($query) use ($editMouldId, $mouldIds) {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('m', 'mp')
                        ->from('MainBundle:Mould', 'm')
                        ->leftJoin('m.product', 'mp')
                        ->groupBy('m.id')
                        ->where('mp.id is null')
                        ->having('COUNT(mp.id) < m.mouldType');
                    if($editMouldId) {
                        $result
                            ->orWhere('m.id IN (:ids)')
                            ->setParameter(':ids', $mouldIds);
                    }

                    return $result;
                }
            ))
            ->add('responsiblePersons', null, array('label' => 'responsible_person'))
            ->add('spares')
            ->add('elPower')
            ->add('weight')
            ->add('carryingPrice')
            ->add('factualPrice')
            ->add('inspectionPeriod')
            ->add('fms_multiple_file', FmsMultipleFileType::class, ['label'=>'files']);
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
            ->add('getStringState', null, array('label'=>'State'))
            ->add('product')
            ->add('mould')
            ->add('deployment', null, ['label' => 'Deployment'])
            ->add('getTypeString', null, ['label' => 'equipment_type'])
            ->add('spares')
            ->add('getEquipmentImages', null, ['template' => 'MainBundle:Admin:equipment_image_list.html.twig', 'label'=>'Images'])
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

        $this->prePersist($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
        $this->addImages($object);
        $this->setRelations($object);

        //get selected equipment type and set it
        $request = $this->getRequest();
        $formName = $this->getFormBuilder()->getName();
        $data = $request->request->get($formName);
        $type1 = $data['type1'];
        $type2 = $data['type2'];

        $type = $type1;

        if(!$type) {
            $type = $type2 ? $type2 : 0;
        }

        $object->setEquipmentType($type);
    }
}
