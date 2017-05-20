<?php

namespace MainBundle\Admin;

use MainBundle\Traits\Meeting\Meeting;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MeetingAdmin extends AbstractAdmin
{
    use Meeting;

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin/Edit:meeting_edit.html.twig';
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
            ->add('status')
            ->add('type')
            ->add('date','doctrine_orm_date_range', ['label' => 'meeting_date', 'show_filter' => false], 'sonata_type_date_range_picker',
                [
                    'field_options_start' => ['format' => 'yyyy-MM-dd'],
                    'field_options_end' => ['format' => 'yyyy-MM-dd']
                ]
            )
            ->add('place')
            ->add('subject')
            ->add('schedule')
            ->add('member')
            ->add('listen')
            ->add('decided')
            ->add('tasks')
            ->add('chairPerson')
            ->add('secretary')
            ->add('state')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('date', null, ['label'=> 'meeting_date'])
            ->add('place', null, ['label'=>'meeting_place', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('type', null, ['label'=>'type', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('subject', null, ['label'=>'meeting_subject', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('state', null, ['label'=>'meeting_state'])
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
        //get object id
        $subject = $this->getSubject();

        //generate array fields data
        $typeArrayData = $this->generateTypeArray($subject);
        $placeArrayData = $this->generatePlaceArray($subject);
        $subjectArrayData = $this->generateSubjectArray($subject);
        $chairPersonArray = $this->generateChairPersonArray($subject);
        $secretaryArray = $this->generateSecretaryArray($subject);

        $formMapper
            ->add('status', 'choice', ['choices'=> ['Հերթական', 'Արտահերթ'], 'required'=>false, 'label'=>'meeting_status'])
            ->add('type', 'choice', ['choices'=> $typeArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'type'])
            ->add('anotherType', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('date', 'sonata_type_date_picker', ['label'=> 'meeting_date', 'required'=>false, 'dp_pick_time'=>true])
            ->add('place', 'choice', ['choices'=> $placeArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_place'])
            ->add('anotherPlace', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('subject', 'choice', ['choices'=> $subjectArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_subject'])
            ->add('anotherSubject', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('schedule', null, ['label'=>'meeting_schedule', 'attr'=>['readonly'=>true]])
            ->add('member', null, ['label'=>'meeting_member', 'attr'=>['readonly'=>true]])
            ->add('listen', 'textarea', ['label'=>'meeting_listen', 'required'=>false])
            ->add('decided', 'textarea', ['required'=>false, 'label'=>'meeting_decided'])
            ->add('tasks', null, ['label'=>'meeting_tasks', 'attr'=>['readonly'=>true]])
            ->add('chairPerson', 'choice', ['choices'=> $chairPersonArray, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_chair_person'])
            ->add('anotherChairPerson', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('secretary', 'choice', ['choices'=> $secretaryArray, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_secretary'])
            ->add('anotherSecretary', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('state', null, ['label'=>'meeting_state', 'attr'=>['readonly'=>true]])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('type', null, ['label'=>'type', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('date', null, ['label'=>'meeting_date'])
            ->add('place', null, ['label'=>'meeting_place', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('subject', null, ['label'=>'meeting_subject', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('schedule', null, ['label'=>'meeting_schedule'])
            ->add('member', null, ['label'=>'meeting_member'])
            ->add('listen', null, ['label'=>'meeting_listen'])
            ->add('decided', null, ['label'=>'meeting_decided'])
            ->add('tasks', null, ['label'=>'meeting_tasks'])
            ->add('chairPerson', null, ['label'=>'meeting_chair_person','template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('secretary', null, ['label'=>'meeting_secretary', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('state', null, ['label'=>'meeting_state']);
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
        $this->checkAndSetType($object);
        $this->checkAndSetPlace($object);
        $this->checkAndSetSubject($object);
        $this->checkAndSetChairPerson($object);
        $this->checkAndSetSecretary($object);
    }
}
