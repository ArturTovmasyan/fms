<?php

namespace MainBundle\Admin;

use MainBundle\Traits\Resource\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    use Product;

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
        $query->addSelect('m, e, c, pw, pl, pre, rm', 'pc', 'rc');
        $query->leftJoin($query->getRootAlias() . '.mould', 'm');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'e');
        $query->leftJoin($query->getRootAlias() . '.client', 'c');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.purposeList', 'pl');
        $query->leftJoin($query->getRootAlias() . '.productRawExpense', 'pre');
        $query->leftJoin('pre.rawMaterials', 'rm');
        $query->leftJoin($query->getRootAlias() . '.productComponent', 'pc');
        $query->leftJoin('pc.routeCard', 'rc');
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
                return 'MainBundle:Admin/Edit:product_edit.html.twig';
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
            ->add('getSumRawExpense', null, ['label' => 'raw_expense'])
            ->add('description','textarea')
            ->add('gost')
            ->add('generalCount', null, ['label' => 'general_count'])
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('workshop', null, ['label' => 'workshop'])
            ->add('weight')
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('equipment', null, ['label' => 'equipment'])
            ->add('mould', null, ['label' => 'mould'])
            ->add('created', 'date', ['widget' => 'single_text'])
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get product id for edit
        $editProductId = $this->getSubject() ? $this->getSubject()->getId() :  null;

        $mouldIds = [];

        $moulds = $this->getSubject()->getMould();

        foreach ($moulds as $mould)
        {
            $mouldIds[] = $mould->getId();
        }

        $formMapper
            ->tab('Ընդհանուր')
            ->add('name')
            ->add('client')
            ->add('equipment', null, [
                'label' => 'equipment',
                'query_builder' => function($query)  {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('eq')
                        ->from('MainBundle:Equipment','eq')
                        ->leftJoin('eq.product', 'ep')
                        ->where('eq.type = :type')
                        ->setParameter(':type', 1);

                    return $result;
                }
            ])
            ->add('mould', null, [
                'label' => 'mould',
                'query_builder' => function($query) use ($editProductId, $mouldIds) {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('m')
                        ->from('MainBundle:Mould', 'm')
                        ->leftJoin('m.product', 'mp')
                        ->groupBy('m.id')
                        ->where('mp.id is null')
                        ->having('COUNT(mp.id) < m.mouldType');
                    if($editProductId) {

                        $result->resetDqlPart('having');

                        $result
                            ->orWhere('m.id IN (:ids)')
                            ->setParameter(':ids', $mouldIds);
                    }

                    return $result;
                }
            ])
            ->add('description', 'textarea', ['required' => false])
            ->add('gost')
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('generalCount', null, ['label' => 'general_count'])
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('size', 'choice', ['required'=>false,
                'choices'=> ['Կգ', 'Մետր','Հատ','Կոմպլեկտ', 'Լիտր']
            ])
            ->add('workshop', 'sonata_type_model', ['label' => 'workshop', 'required'=>false, 'btn_add' => "Ավելացնել արտադրամաս",])
            ->add('weight')
            ->end()
            ->end();
        if($editProductId) {
            $formMapper
            ->tab('raw_expense')
                ->with('product_expense')
                ->add('productRawExpense', 'sonata_type_collection', [
                    'label' => false,
                    'by_reference' => false,
                    'required' => false,
                    'btn_add' => "Ավելացնել նյութածախս",
                    'type_options' => [
                        'delete' => true]
                ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ])
                ->end()
                ->end()

            ->tab('route_card')

                ->add('productComponent', 'sonata_type_collection', [
                    'label' => false,
                    'by_reference' => false,
                    'required' => false,
                    'btn_add' => 'Ավելացնել երթուղային քարտ',
                    'type_options' => [
                        'delete' => true]
                ],
                    [
                        'edit' => 'inline',
                        'inline' => 'inline'
                    ])
                ->end()
                ->end();
        };

    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['show_filter' => true])
            ->add('gost')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['label'=>'code', 'template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('getSumRawExpense', null, ['label' => 'raw_expense', 'template'=>'MainBundle:Admin/List:product_expense_list.html.twig'])
            ->add('getSumRouteCard', null, ['label' => 'route_card', 'template'=>'MainBundle:Admin/List:product_routeCard_list.html.twig'])
            ->add('client')
            ->add('gost')
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('workshop', null, ['label' => 'workshop'])
            ->add('equipment', null, ['label' => 'equipment'])
            ->add('mould', null, ['label' => 'mould'])
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