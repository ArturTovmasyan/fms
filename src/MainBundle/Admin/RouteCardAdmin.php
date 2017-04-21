<?php

namespace MainBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteCardAdmin extends Admin
{
    //set fields option
    protected $formOptions = [
        'cascade_validation' => true,
    ];

    /**
     * override list query
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface */

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->addSelect('pr, pc, eq, ml');
        $query->leftJoin($query->getRootAlias() . '.profession', 'pr');
        $query->leftJoin($query->getRootAlias() . '.productComponent', 'pc');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');

        return $query;
    }

    protected $baseRoutePattern = 'route_card';

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'MainBundle:Admin/List:productRouteCardList.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    //hide remove and edit buttons
    protected function configureRoutes(RouteCollection $collection)
    {
//        $collection->remove('delete');
//        $collection->remove('edit');
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('operation')
            ->add('operationCode')
            ->add('dependency')
            ->add('equipment')
            ->add('mould')
            ->add('profession')
            ->add('professionCategory')
            ->add('jobTime')
            ->add('routeCardPrice')
            ->add('specificPercent')
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
       //$productId = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject()->getId();
        $builder = $formMapper->getFormBuilder();
        $factory = $builder->getFormFactory();
        $currentId = $this->getSubject() ? $this->getSubject()->getId() : null;
        $helpText = 'First manually';
        $choices = null;


        if($currentId) {
            $choices = $this->getSubject()->getDependency();
        }

        $changeDependency = function (FormEvent $event) use ($factory) {
            $form = $event->getForm();
            $data = $event->getData();

            $form->add('dependency', 'choice', [
                'choices' => [
                    $data['dependency'] => $data['dependency'],
                ]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $changeDependency);

        $formMapper
            ->add('operation', null, ['label'=>'route_card_operation'])
            ->add('operationCode', null, ['label'=>'code', 'sonata_help' => $helpText, 'attr' => [
                'readonly' => false
                ]])
            ->add('dependency', 'choice', [
                'label'=>'dependency',
                'required'=>false,
                'choices'=> [$choices => $choices],
                'attr'=> ['class'=>$choices]
            ])

            ->add('equipment', null, [
            ])
            ->add('mould', null, [
            ])
            ->add('profession', null, ['label'=>'profession_route_card'])
            ->add('professionCategory', 'choice', [
                'mapped'=>false,
                'required'=>false,
                'label'=>'profession_category'])
            ->add('jobTime', null, ['label'=>'job_time', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('tariff', 'number', ['required'=>false, 'mapped'=>false, 'label'=>'tariff', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('sum', 'number', ['required'=>false, 'mapped'=>false,'label'=>'sum', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
            ->add('specificPercent', null, ['label'=>'specific_percent', 'attr' => [
                'readonly' => true,
                'disabled' => true]])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('profession')
            ->add('operation')
            ->add('operationCode')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('operation', null, ['label'=>'route_card_operation'])
            ->add('operationCode', null, ['label'=>'code'])
            ->add('dependency', null, ['label'=>'dependency'])
            ->add('equipment')
            ->add('mould')
            ->add('profession', null, ['label'=>'profession_route_card'])
            ->add('professionCategory', null, ['label'=>'profession_category'])
            ->add('jobTime', null, ['label'=>'job_time'])
            ->add('specificPercent', null, ['label'=>'specific_percent'])
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