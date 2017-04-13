<?php

namespace MainBundle\Admin;

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
            ->add('actualCost', null, ['label' => 'actual_cost'])
            ->add('balanceCost', null, ['label' => 'balance_cost'])
            ->add('description', 'textarea', ['required'=>false])
            ->add('code')
            ->add('size', 'choice', ['label' => 'size', 'required'=>false,  'choices' => [
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր"]])
            ->add('placeWarehouse', null, ['label' => 'place_warehouse'])
            ->add('countInWarehouse', null, ['label' => 'counts_in_warehouse'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id]);
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

