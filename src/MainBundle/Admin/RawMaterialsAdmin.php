<?php

namespace MainBundle\Admin;

use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RawMaterialsAdmin extends Admin
{
    use FmsAdmin;
    const imageClassName = 'RawMaterialImages';

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
        $query->addSelect('v, pw');
        $query->leftJoin($query->getRootAlias() . '.vendors', 'v');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');

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
                return 'MainBundle:Admin/Edit:fms_edit.html.twig';
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
            ->add('description')
            ->add('getStringSize', null, ['label' => 'size'])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('vendors')
            ->add('actualCost')
            ->add('balanceCost')
            ->add('updated', 'date', ['widget' => 'single_text'])
            ->add('created', 'date', ['widget' => 'single_text']);
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        //get object id and check action
        $id = null;
        $route = $this->getRequest()->getUri();
        $routeArray = explode('/', $route);
        $action = end($routeArray);

        if (strpos($action, 'edit') !== false) {
            $key = count($routeArray) - 2 ;
            $id = $routeArray[$key];
        }

        $formMapper
            ->add('description')
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('vendors')
            ->add('actualCost')
            ->add('balanceCost')
            ->add('size', 'choice', ['label' => 'size', 'choices' => [
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր"]])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['show_filters' => true])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
//            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_material_id_show.html.twig'])
            ->add('name')
            ->add('description')
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('vendors')
            ->add('actualCost',  null, ['label' => 'actual_price'])
            ->add('balanceCost', null, ['label' => 'accounting_price'])
            ->add('getStringSize', null, ['label' => 'size'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->prePersist($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        //set relation for object and images
        $images = $this->getImages(self::imageClassName);
        $this->addImages($object, $images);
    }

    /**
     * This function is used to get child constant
     */
    public function getMyConstant(){
        return self::imageClassName;
    }
}

