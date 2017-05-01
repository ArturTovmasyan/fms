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

class RouteCardAdmin extends Admin
{
    //set fields option
    protected $formOptions = [
        'cascade_validation' => true
    ];

    /**
     * override list query
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface */

    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();
        $productId = $request->query->get('productId');

        $query = parent::createQuery($context);
        $query->addSelect('pr, pc, eq, ml');
        $query->leftJoin($query->getRootAlias() . '.profession', 'pr');
        $query->leftJoin($query->getRootAlias() . '.productComponent', 'pc');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
        $query->leftJoin($query->getRootAlias() . '.mould', 'ml');

        if($productId) {
            $query->leftJoin('pc.product', 'prd');
            $query->where('prd.id = :productId')
                ->setParameter('productId', $productId);
        }

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
            case 'edit':
                return 'MainBundle:Admin/Edit:route_card_edit.html.twig';
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
        $currentId = $this->getSubject() ? $this->getSubject()->getId() : null;

        //$parentFieldDesc = $formMapper->getAdmin()->getParentFieldDescription()->getAdmin()->getSubject();

        $helpText = 'First code set manually';
        $choice = null;
        $profCategory = null;

        //check if page is edit
        if($currentId) {
            $choice = $this->getSubject()->getDependency();
            $profCategory = $this->getSubject()->getProfessionCategory();
        }

        //change and save choices value
        $changeSelectedFields = function (FormEvent $event) {

            $form = $event->getForm();
            $data = $event->getData();

            if(array_key_exists('dependency', $data)) {
                $form->add('dependency', 'choice', [
                    'label'=>'dependency',
                    'choices' => [
                        $data['dependency'] => $data['dependency'],
                    ]
                ]);
            }

            if(array_key_exists('professionCategory', $data)) {
                $form->add('professionCategory', 'choice', [
                    'label'=>'profession_category',
                    'choices' => [
                        $data['professionCategory'] => $data['professionCategory']
                    ]
                ]);
            }
        };

        //create form events for manage dependency data in form
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $changeSelectedFields);

        $formMapper
            ->add('operation', null, ['label'=>'route_card_operation'])
            ->add('operationCode', null, ['label'=>'code',
                'sonata_help' => $helpText,
                'attr' => [
                    'placeholder'=>'Example K1O1',
                    'readonly' => false
            ]])
            ->add('dependency', 'choice', [
                'label'=>'dependency',
                'required'=>false,
                'choices'=> [$choice => $choice]
            ])
            ->add('equipment', null, [])
            ->add('mould', null, [])
            ->add('profession', null, ['required'=>false, 'label'=>'profession_route_card'])
            ->add('professionCategory', 'choice', [
                'label'=>'profession_category',
                'required'=>false,
                'choices'=> [$profCategory => $profCategory]
            ])
            ->add('jobTime', null, ['label'=>'job_time'])
            ->add('tariff', 'number', ['required'=>true, 'label'=>'tariff', 'attr' => [
                'readonly' => true
            ]])
            ->add('sum', 'number', ['required'=>true, 'label'=>'sum', 'attr' => [
                'readonly' => true
            ]])
            ->add('specificPercent', null, ['label'=>'specific_percent'])
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
            ->add('tariff', 'number', ['required'=>true, 'label'=>'tariff'])
            ->add('sum', 'number', ['required'=>true, 'label'=>'sum'])
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