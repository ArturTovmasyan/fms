<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TariffAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('hourSalary')
            ->add('daySalary')
            ->add('rate')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        $tariffId = $subject ? $subject->getId() : null;
        $addBtn = 'Ավելացնել կարգ';

        //hide add button if tariff has category
        if($subject && $subject->getProfessionCategory()) {
            $addBtn = false;
        }

        $em = $this->modelManager->getEntityManager('MainBundle:ProfessionCategory');
        $query = $em->createQueryBuilder('c');

        $query->select('c')
            ->from('MainBundle:ProfessionCategory', 'c')
            ->leftJoin('c.tariff', 'tf')
            ->where('tf.id IS NULL');

        if($tariffId) {
            $query
                ->orWhere('tf.id = :id')
                ->setParameter('id', $tariffId);
        }

        $formMapper
            ->add('professionCategory', 'sonata_type_model', [
                'label' => 'profession_category',
                'required'=>true,
                'btn_add' => $addBtn,
                'query' => $query
            ])
            ->add('hourSalary', null, ['required'=>true, 'label'=>'salary_hour'])
            ->add('daySalary', null, ['required'=>true, 'label'=>'salary_day'])
            ->add('rate', null, ['required'=>true, 'label'=>'salary_rate'])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('hourSalary')
            ->add('daySalary')
            ->add('rate')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('professionCategory', null, ['label' => 'profession_category'])
            ->add('hourSalary')
            ->add('daySalary')
            ->add('rate')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }
}