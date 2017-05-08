<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ToolsChronologyAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'tools_chronology';


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
            ->add('personnel')
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
            ->add('personnel', null, ['label' => 'tools_person'])
            ->add('fromDate', null, ['label' => 'tools_chronology_from_date'])
            ->add('toDate', null, ['label' => 'tools_chronology_to_date'])
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
            ->add('personnel', null, ['label' => 'tools_person'])
            ->add('fromDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_from_date'])
            ->add('toDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_to_date'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('personnel')
            ->add('fromDate')
            ->add('toDate')
        ;
    }
}
