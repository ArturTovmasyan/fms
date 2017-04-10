<?php

namespace MainBundle\Admin;

use Doctrine\ORM\Query;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostHistoryAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'post_history';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        // call parent query
        $query = parent::createQuery($context);

        // add selected
        $query->addSelect('pt, ps');
        $query->leftJoin($query->getRootAlias() . '.post', 'pt');
        $query->leftJoin($query->getRootAlias() . '.personnel', 'ps');

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('post', null, ['show_filter'=>true, 'label'=>'post'])
            ->add('personnel', null, ['show_filter'=>true, 'label'=>'personnel'])
            ->add('fromDate', null, ['label'=>'from_date'])
            ->add('toDate', null, ['label'=>'to_date'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('post', null, ['label'=>'post'])
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('fromDate', null, ['label'=>'from_date'])
            ->add('toDate', null, ['label'=>'to_date'])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('post', null, ['label'=>'post'])
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('fromDate','sonata_type_date_picker', ['label'=>'from_date'])
            ->add('toDate','sonata_type_date_picker', ['label'=>'to_date', 'required'=>false]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('post', null, ['label'=>'post'])
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('fromDate')
            ->add('toDate');
    }
}
