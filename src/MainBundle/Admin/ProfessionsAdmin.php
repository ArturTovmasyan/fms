<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProfessionsAdmin extends Admin
{

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('tariff');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('tariff', 'sonata_type_collection', [
                'label' => 'tariff',
                'btn_add' => 'Ավելացնել տարիֆ',
                'by_reference' => false,
                'mapped'   => true,
                'required' => true],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            );
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function setRelations($object)
    {
        //get tariffs
        $tariffs = $object->getTariff();

        foreach($tariffs as $tariff)
        {
            if(!$tariffs->contains($object))
            {
                $tariff->setProfession($object);
            }
        }
    }

    public function preUpdate($object)
    {
        $this->setRelations($object);
    }

    public function prePersist($object)
    {
        $this->setRelations($object);
    }

}
