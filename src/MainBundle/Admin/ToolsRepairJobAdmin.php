<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ToolsRepairJobAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'tools_repair_job';

    /**
     * override list query
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface */

    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();
        $toolId = $request->query->get('toolId');

        // call parent query
        $query = parent::createQuery($context);

        // add selected
        $query->addSelect('t');
        $query->leftJoin($query->getRootAlias() . '.tool', 't');

        if($toolId) {
            $query->where('t.id = :toolId')
                ->setParameter('toolId', $toolId);
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('description')
            ->add('fromDate')
            ->add('toDate')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('description')
            ->add('fromDate', null, ['label' => 'tools_repair_from_date'])
            ->add('toDate', null, ['label' => 'tools_repair_to_date'])
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
            ->add('description', 'textarea')
            ->add('fromDate', 'sonata_type_date_picker', ['label' => 'tools_repair_from_date'])
            ->add('toDate', 'sonata_type_date_picker', ['label' => 'tools_repair_to_date'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('description')
            ->add('fromDate')
            ->add('toDate')
        ;
    }
}
