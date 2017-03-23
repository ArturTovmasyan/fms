<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\ToolMultipleFile;
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
                return 'MainBundle:Admin:fms_edit.html.twig';
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
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('created', 'date', array('widget' => 'single_text'))
            ->add('images', null, ['template' => 'MainBundle:Admin:fms_image_show.html.twig', 'label'=>'files'])
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
            ->add('category', null, array('required' => true))
            ->add('vendors')
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('description', 'ckeditor')
            ->add('code')
            ->add('size', 'choice', array('label' => 'size', 'choices' => array(
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր")))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
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
            ->add('name')
            ->add('category')
            ->add('vendors')
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('code')
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('getToolImages', null, ['template' => 'MainBundle:Admin:fms_image_list.html.twig', 'label'=>'files'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
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

