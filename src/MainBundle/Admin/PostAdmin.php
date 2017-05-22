<?php

namespace MainBundle\Admin;

use MainBundle\Model\PersonnelFilterInterface;
use MainBundle\Traits\Personnel\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin implements PersonnelFilterInterface
{
    use Post;

    const imageClassName = 'PostImages';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        // call parent query
        $query = parent::createQuery($context);

        // add selected
        $query->addSelect('d, ins, p, h, w, cg, cd');
        $query->leftJoin($query->getRootAlias() . '.division', 'd');
        $query->leftJoin($query->getRootAlias() . '.instructions', 'ins');
        $query->leftJoin($query->getRootAlias() . '.personnel', 'p');
        $query->leftJoin($query->getRootAlias() . '.history', 'h');
        $query->leftJoin($query->getRootAlias() . '.workers', 'w');
        $query->leftJoin($query->getRootAlias() . '.changing', 'cg');
        $query->leftJoin($query->getRootAlias() . '.changed', 'cd');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin/Edit:post_edit.html.twig';
                break;
            case 'list':
                return 'MainBundle:Admin/List:post_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('code')
            ->add('postStatus', null, ['label'=>'post_status'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->enablePersonnelFilter();

        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('code')
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('history', null, ['template' => 'MainBundle:Admin/List:post_history_list.html.twig', 'label'=>'post_history'])
            ->add('postStatus', null, ['label'=>'post_status'])
            ->add('getStringEducation', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('age', null, ['label'=>'age'])
            ->add('experience', null, ['label'=>'experience'])
            ->add('language', null, ['label'=>'language', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('requirement', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig', 'label'=>'post_req'])
            ->add('workers', null, ['label'=>'workers'])
            ->add('functions', null, ['label'=>'functions'])
            ->add('powers', null, ['label'=>'powers'])
            ->add('responsibility;', null, ['label'=>'responsibility'])
            ->add('obligations', null, ['label'=>'obligations'])
            ->add('changing', null, ['label'=>'changing'])
            ->add('changed', null, ['label'=>'changed'])
            ->add('instructions', null, ['label'=>'instructions'])
            ->add('jobAgreement', null, ['label'=>'job_agreement'])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->enablePersonnelFilter();

        //get division id by request
        $divisionId = $this->getRequest()->query->get('divisionId');
        $subject = $this->getSubject();
        $id = $subject ? $subject->getId() : null;

        $personnelId = $subject->getPersonnel() ? $subject->getPersonnel()->getId() : null;

        //generate array fields data
        $langArrayData = $this->generateLanguageArray($subject);
        $compEducationArrayData = $this->generateCompEducationArray($subject);
        $requireArrayData = $this->generateRequirementArray($subject);

        $educationArray = [
            'Բարձրագույն',
            'Միջին մասնագիտական',
            'Միջնակարգ',
            'Առանց սահմանափակման'
        ];


        $formMapper
            ->tab('global_info')
            ->add('name')
            ->add('code')
            ->add('division', null, ['label'=>'division_chief'])
             ->add('personnel', null, [
                'label' => 'personnel',
                'query_builder' => function($query) use ($id, $personnelId)  {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('pe')
                        ->from('MainBundle:Personnel','pe')
                        ->leftJoin('pe.post', 'pt')
                        ->where('pt.id is NULL');

                    if($id) {
                        $result
                            ->orWhere('pe.id = :personnelId')
                            ->setParameter(':personnelId', $personnelId);
                    }

                    return $result;
                }
             ]);

        $formMapper
            ->add('postStatus', null, ['label'=>'post_status'])
            ->add('educationStatus', 'choice', ['label'=>'education', 'choices'=> $educationArray, 'required'=>false])
            ->add('language', 'choice', ['label'=>'language','choices'=> $langArrayData, 'required'=>false, 'multiple'=>true])
            ->add('anotherLang', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_language'], 'label'=>false, 'required'=>false])
            ->add('compKnowledge', 'choice', ['choices'=> $compEducationArrayData, 'required'=>false, 'label'=>'comp_knowledge', 'multiple'=>true])
            ->add('anotherCompEducation', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_comp_knowledge'], 'label'=>false, 'required'=>false])
            ->add('requirement', 'choice', ['choices'=> $requireArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'post_req'])
            ->add('anotherRequirement', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'post_req'], 'label'=>false, 'required'=>false])
            ->add('profession', null, ['label'=>'profession'])
            ->add('age', null, ['label'=>'age'])
            ->add('experience', null, ['label'=>'experience'])
            ->end()
            ->end()
            ->tab('job_info')
            ->add('workers', null, ['label'=>'workers'])
            ->add('functions', null, ['label'=>'functions'])
            ->add('powers', null, ['label'=>'powers'])
            ->add('obligations', null, ['label'=>'obligations'])
            ->add('responsibility', 'textarea', ['label'=>'responsibility', 'required'=>false])
            ->end()
            ->with('post_changing')
            ->add('changing', null, ['label'=>'changing'])
            ->add('changed', null, ['label'=>'changed'])
            ->end()
            ->add('instructions', null, ['label'=>'instructions'])
            ->add('jobAgreement', null, ['label'=>'job_agreement'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('divisionId', 'hidden', ['mapped'=>false, 'attr' => ['class' => $divisionId]])
            ->end()
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->enablePersonnelFilter();

        $showMapper
            ->tab('global_info')
            ->add('name')
            ->add('code')
            ->add('division', null, ['label'=>'division_chief'])
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('postStatus', null, ['label'=>'post_status'])
            ->add('language', null, ['label'=>'language', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('getStringEducation', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('age', null, ['label'=>'age'])
            ->add('experience', null, ['label'=>'experience'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('requirement', null, ['template' => 'MainBundle:Admin/Show:post_array_show.html.twig', 'label'=>'post_req'])
            ->end()
            ->end()
            ->tab('job_info')
            ->add('workers', null, ['label'=>'workers'])
            ->add('functions', null, ['label'=>'functions'])
            ->add('powers', null, ['label'=>'powers'])
            ->add('obligations', null, ['label'=>'obligations'])
            ->end()
            ->with('post_changing')
            ->add('changing', null, ['label'=>'changing'])
            ->add('changed', null, ['label'=>'changed'])
            ->end()
            ->add('instructions', null, ['label'=>'instructions'])
            ->add('jobAgreement', null, ['label'=>'job_agreement'])
            ->add('created', null, ['label'=>'created'])
            ->add('updated', null, ['label'=>'updated'])
            ->end()
            ->end();
    }


    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->prePersist($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        //get personnel data and manage it
        $personnel = $object->getPersonnel();
        $personnelInForm = $this->getForm()->get('personnel')->getData();

        if(!$personnelInForm && $personnel) {
            $personnel->setPost(null);
        }

        //check and set array fields data
        $this->checkAndSetLanguages($object);
        $this->checkAndSetCompEducation($object);
        $this->checkAndSetRequirement($object);

        $this->removeRelations($object);
        $this->setRelation($object);
    }

    /**
     * This function is used to disable custom doctrine filter
     */
    public function enablePersonnelFilter()
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $em->getFilters()->enable('visibility_filter');
    }
}

