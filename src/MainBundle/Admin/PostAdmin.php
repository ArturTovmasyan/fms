<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('postStatus')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('postStatus')
            ->add('getStringEducation')
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('language')
            ->add('compKnowledge')
            ->add('requirement')
            ->add('chief')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('responsibility')
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
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
            ->add('name')
            ->add('code')
            ->add('postStatus')
            ->add('educationStatus', 'choice', array('choices'=> array(
                0 => ' ',
                1 => 'Բարձրագույն',
                2 => 'Միջին մասնագիտական',
                3 => 'Միջնակարգ',
                4 =>'Առանց սահմանափակման'), 'required'=>false))
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('language')
            ->add('compKnowledge')
            ->add('requirement')
            ->add('chief')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('responsibility')
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('postStatus')
            ->add('getStringEducation')
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('language')
            ->add('compKnowledge')
            ->add('requirement')
            ->add('chief')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('responsibility')
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
            ->add('created')
            ->add('updated')
        ;
    }
}
