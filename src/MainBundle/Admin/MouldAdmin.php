<?php

namespace MainBundle\Admin;

use /** @noinspection PhpDeprecationInspection */
    Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MouldAdmin extends Admin
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
        $query->addSelect('p, pw, eq');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
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
                return 'MainBundle:Admin/Edit:mould_edit.html.twig';
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
            ->add('code', null, ['label' => 'code'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('getStringState', null, ['label' => 'current_state'])
            ->add('preparationTime', 'date', ['widget'=>'single_text', 'label' => 'preparation_time'])
            ->add('lastRepair', 'date', ['label' => 'last_repair', 'widget' => 'single_text'])
            ->add('cost', null, ['label' => 'cost_price'])
            ->add('actualPrice', null, ['label' => 'actual_price'])
            ->add('accountingPrice', null, ['label' => 'accounting_price'])
            ->add('generalCount', null, ['label' => 'general_count'])
            ->add('created', 'datetime', ['widget' => 'single_text'])
            ->add('product')
            ->add('bandwidth')
            ->add('mouldType', null, ['label' => 'mould_type'])
            ->add('equipment')
            ->add('description')
            ->add('image')
            ->add('sketch')
            ->add('weight')
            ->add('overSize', null, ['label' => 'over_size'])
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('code')
            ->add('product')
            ->add('equipment', null, [
                'label' => 'equipment',
                'query_builder' => function($query) {
                    $result = $query->createQueryBuilder('m');
                    $result
                        ->select('eq', 'ml')
                        ->from('MainBundle:Equipment','eq')
                        ->leftJoin('eq.mould', 'ml')
                        ->where('eq.type = :type')
                        ->setParameter(':type', 1);

                    return $result;
                }
            ])
            ->add('mouldType', null, ['label' => 'mould_type'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('description')
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('currentState', 'choice', ['label' => 'current_state', 'choices'=> [
                "Նորմալ",
                "Վերանորոգման ենթակա",
                "Անպիտան",
                "Ձևափոխված"]])
            ->add('bandwidth')
            ->add('generalCount', null, ['label' => 'general_count'])
            ->add('preparationTime', 'date', ['widget' => 'single_text', 'label' => 'preparation_time'])
            ->add('lastRepair', 'date', ['label' => 'last_repair', 'widget' => 'single_text'])
            ->add('cost')
            ->add('actualPrice', null, ['label' => 'actual_price'])
            ->add('accountingPrice', null, ['label' => 'accounting_price'])
            ->add('weight')
            ->add('overSize', null, ['label' => 'over_size'])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('placeWarehouse')
            ->add('mouldType', null, ['label' => 'mould_type'])
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('code')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['label'=>'code', 'template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('code')
            ->add('product')
            ->add('mouldType', null, ['label' => 'mould_type'])
            ->add('purposeList', null, ['label' => 'Purpose'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('equipment')
            ->add('getStringState', null, ['label' => 'current_state'])
            ->add('generalCount', null, ['label' => 'general_count'])
            ->add('cost')
            ->add('actualPrice', null, ['label' => 'actual_price'])
            ->add('accountingPrice', null, ['label' => 'accounting_price'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function removeRelations($object)
    {
        //get products
        $products = $object->getProduct();

        //get removed products in mould
        $removed = $products->getDeleteDiff();

        if($removed) {

            foreach($removed as $remove)
            {
                $remove->removeMould($object);
            }
        }

    }
    //set relations for Equipment
    public function setRelations($object)
    {
        //get products
        $products = $object->getProduct();

        if($products) {

            foreach($products as $product)
            {
                $productMoulds = $product->getMould();

                if(!$productMoulds->contains($object))
                {
                    $product->addMould($object);
                }
            }
        }
    }

    public function preUpdate($object)
    {
        $this->prePersist($object);
        $this->removeRelations($object);
    }

    public function prePersist($object)
    {
       $this->setRelations($object);
    }
}

