<?php

namespace MainBundle\Admin;

use MainBundle\Traits\Personnel\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin
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
        $query->addSelect('d, ins, p, im, cg, cd');
        $query->leftJoin($query->getRootAlias() . '.division', 'd');
        $query->leftJoin($query->getRootAlias() . '.instructions', 'ins');
        $query->leftJoin($query->getRootAlias() . '.personnel', 'p');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');
        $query->leftJoin($query->getRootAlias() . '.changing', 'cg');
        $query->leftJoin($query->getRootAlias() . '.changed', 'cd');

        return $query;
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
            ->add('id')
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
        $listMapper
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('postStatus', null, ['label'=>'post_status'])
            ->add('getStringEducation', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('age', null, ['label'=>'age'])
            ->add('experience', null, ['label'=>'experience'])
            ->add('language', null, ['label'=>'language', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('requirement', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig', 'label'=>'post_req'])
            ->add('chief', null, ['label'=>'chief'])
            ->add('workers', null, ['label'=>'workers'])
            ->add('functions', null, ['label'=>'functions'])
            ->add('powers', null, ['label'=>'powers'])
            ->add('responsibility;', null, ['label'=>'responsibility'])
            ->add('obligations', null, ['label'=>'obligations'])
            ->add('changing', null, ['label'=>'changing'])
            ->add('changed', null, ['label'=>'changed'])
            ->add('instructions', null, ['label'=>'instructions'])
            ->add('jobAgreement', null, ['label'=>'job_agreement'])
//            ->add('history', null, ['label'=>'post_story'])
            ->add('getPostImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
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
        //get division id by request
        $divisionId = $this->getRequest()->query->get('divisionId');
        $subject = $this->getSubject();
        $id = $subject ? $subject->getId() : null;

        //get current class name
        $className = $this->getClassnameLabel();

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
            ->add('name', null, ['attr'=>['class' => $className.' '. self::imageClassName]])
            ->add('code')
            ->add('division', null, ['label'=>'division_chief'])
             ->add('personnel', null, array(
//                'label' => 'personnel',
//                'query_builder' => function($query)   {
//                    $result = $query->createQueryBuilder('p');
//                    $result
//                        ->select('pe')
//                        ->from('MainBundle:Personnel','pe')
//                        ->leftJoin('pe.post', 'pt')
//                        ->where('pt.id is NULL');
//
//                    return $result;
//                }
            ));

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
            ->add('chief', null, ['label'=>'chief'])
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
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id])
            ->end()
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->tab('global_info')
            ->add('id')
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
            ->add('requirement', null, ['label'=>'requirement', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig', 'label'=>'post_req'])
            ->add('chief', null, ['label'=>'chief'])
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
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
//            ->add('history', null, ['label'=>'post_story'])
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
        //check and set array fields data
        $this->checkAndSetLanguages($object);
        $this->checkAndSetCompEducation($object);
        $this->checkAndSetRequirement($object);
    }
}

