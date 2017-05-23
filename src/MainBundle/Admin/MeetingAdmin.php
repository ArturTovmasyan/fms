<?php

namespace MainBundle\Admin;

use MainBundle\Form\MeetingScheduleType;
use MainBundle\Form\MeetingTaskType;
use MainBundle\Model\PersonnelFilterInterface;
use MainBundle\Traits\Meeting\Meeting;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MeetingAdmin extends AbstractAdmin implements PersonnelFilterInterface
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
        $this->enablePersonnelFilter();

        $datagridMapper
            ->add('date','doctrine_orm_date_range', ['label' => 'meeting_date'], 'sonata_type_date_range_picker',
                [
                    'field_options_start' => ['format' => 'yyyy-MM-dd'],
                    'field_options_end' => ['format' => 'yyyy-MM-dd']
                ]
            )
            ->add('place', null, ['labe;'=>'meeting_place'])
            ->add('type', null, ['label'=>'type'])
            ->add('subject', null, ['label'=>'meeting_subject'])
            ->add('state', null, ['label'=>'meeting_state'])
            ->add('member', null, ['label'=>'meeting_member'])
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
            ->add('date', null, ['label'=> 'day', 'template'=>'MainBundle:Admin/List:meeting_date_list.html.twig'])
            ->add('getTime', null, ['label'=> 'time'])
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
        $this->enablePersonnelFilter();

        //get object id
        $subject = $this->getSubject();

        //generate array  data for dynamically select fields
        $typeArrayData = $this->generateTypeArray($subject);
        $placeArrayData = $this->generatePlaceArray($subject);
        $subjectArrayData = $this->generateSubjectArray($subject);
        $chairPersonArray = $this->generateChairPersonArray($subject);
        $secretaryArray = $this->generateSecretaryArray($subject);

        $formMapper
            ->tab('global_info')
            ->add('status', 'choice', ['choices'=> ['Հերթական'=>'Հերթական', 'Արտահերթ'=>'Արտահերթ'], 'required'=>true, 'label'=>'meeting_status'])
            ->add('type', 'choice', ['choices'=> $typeArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'type'])
            ->add('anotherType', 'text', ['mapped'=>false, 'attr' => ['placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('date', 'sonata_type_date_picker', ['label'=> 'meeting_date', 'required'=>false, 'dp_pick_time'=>true, 'format'=>'yyyy/MM/dd H:m:s'])
            ->add('place', 'choice', ['choices'=> $placeArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_place'])
            ->add('anotherPlace', 'text', ['mapped'=>false, 'attr' => ['placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('subject', 'choice', ['choices'=> $subjectArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_subject'])
            ->add('anotherSubject', 'text', ['mapped'=>false, 'attr' => ['placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('listen', 'collection', ['label'=>'meeting_listen', 'required'=>false, 'allow_add'=>true, 'allow_delete'=>true])
            ->add('decided', 'collection', ['required'=>false, 'label'=>'meeting_decided', 'allow_add'=>true, 'allow_delete'=>true])
            ->add('chairPerson', 'choice', ['choices'=> $chairPersonArray, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_chair_person'])
            ->add('anotherChairPerson', 'text', ['mapped'=>false, 'attr' => ['placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('secretary', 'choice', ['choices'=> $secretaryArray, 'required'=>false, 'multiple'=>true, 'label'=>'meeting_secretary'])
            ->add('anotherSecretary', 'text', ['mapped'=>false, 'attr' => ['placeholder'=> 'another_field'],
                'label'=>false, 'required'=>false])
            ->add('state', 'choice', ['choices'=> [
                'Նախատեսվող'=>'Նախատեսվող',
                'Կայացած'=>'Կայացած',
                'Չկայացած/Հետաձգված'=>'Չկայացած/Հետաձգված'],
                'required'=>false, 'label'=>'meeting_state'])
            ->end()
            ->end()

            ->tab('meeting_member')
            ->add('member', null, ['label' => 'meeting_member'])
            ->add('invitors', null, ['label' => 'meeting_invitors'])
            ->add('newInvitors', 'collection', ['mapped'=>false, 'label'=>'Ավելացնել',
                'required'=>false, 'allow_add'=>true, 'allow_delete'=>true])
            ->end()
            ->end()

            ->tab('meeting_schedule')
            ->add('meetingSchedule', 'collection', [
                'label'=>false,
                'type' => new MeetingScheduleType(),
                'allow_add'=>true,
                'allow_delete'=>true]
            )
            ->end()
            ->end()

            ->tab('meeting_tasks')
            ->add('meetingTask', 'collection', [
                'label'=>false,
                'type' => new MeetingTaskType(),
                'allow_add'=>true, 'allow_delete'=>true]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('type', null, ['label'=>'type', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->prePersist($object);
        $this->removeRelations($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        //generate another values for dynamically select values
        $this->setAllDynamicallyData($object);
        $this->addNewInvitors($object);
        $this->setRelation($object);
    }

    /**
     * This function is used to enable personnel filter
     */
    public function enablePersonnelFilter()
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $em->getFilters()->enable('visibility_filter');
    }
}
