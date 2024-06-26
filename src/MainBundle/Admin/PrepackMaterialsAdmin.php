<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PrepackMaterialsAdmin extends RawMaterialsAdmin
{
    protected $baseRoutePattern = 'prepack_materials';

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
        $query->addSelect('p, eq, im');
        $query->leftJoin($query->getRootAlias() . '.product', 'p');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');

        return $query;
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight')
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])

        ;
        parent::configureShowFields($showMapper);

    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        //get current class name
        $className = $this->getClassnameLabel();
        $imageClassName = $this->getMyConstant();

        $formMapper
            ->add('name', null, ['attr'=>['class' => $className.' '. $imageClassName]])
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight')
        ;
        parent::configureDatagridFilters($datagridMapper);
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight')
            ->add('getMaterialImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @return string
     */
    public function getMyConstant() {
        return self::imageClassName;
    }
}

