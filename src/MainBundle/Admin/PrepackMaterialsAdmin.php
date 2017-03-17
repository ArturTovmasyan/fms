<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\MaterialMultipleFileType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PrepackMaterialsAdmin extends RawMaterialsAdmin
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
            ->add('images', null, ['template' => 'MainBundle:Admin:fms_image_show.html.twig', 'label'=>'files'])

        ;
        parent::configureShowFields($showMapper);

    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight')
            ->add('material_multiple_file', MaterialMultipleFileType::class, ['label'=>'files']);
        ;
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
        $listMapper
            ->add('product')
            ->add('equipment')
            ->add('workshop')
            ->add('weight')
            ->add('getMaterialImages', null, ['template' => 'MainBundle:Admin:fms_image_list.html.twig', 'label'=>'files'])
        ;
        parent::configureListFields($listMapper);
    }
}

