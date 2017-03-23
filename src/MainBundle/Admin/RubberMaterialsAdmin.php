<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\MaterialMultipleFileType;
use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RubberMaterialsAdmin extends RawMaterialsAdmin
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
        $query->addSelect('im');
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
            ->add('gost')
            ->add('code')
            ->add('category')
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
            ->add('images', null, ['template' => 'MainBundle:Admin:fms_image_show.html.twig', 'label'=>'files'])
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
            ->add('gost')
            ->add('code')
            ->add('category')
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('gost')
            ->add('code')
            ->add('category')
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
        ;
        parent::configureDatagridFilters($datagridMapper);
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('gost')
            ->add('code')
            ->add('category')
            ->add('minimalVolume', null, array('label' => 'minimal_volume'))
            ->add('getMaterialImages', null, ['template' => 'MainBundle:Admin:fms_image_list.html.twig', 'label'=>'files'])        ;

        parent::configureListFields($listMapper);
    }
}

