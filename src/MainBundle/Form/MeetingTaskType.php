<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10/20/15
 * Time: 6:06 PM
 */

namespace MainBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MeetingTaskType
 * @package MainBundle\Form
 */
class MeetingTaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delegate', null, ['label' => 'meeting_delegate'])
            ->add('recipient', null, ['label' => 'meeting_reporter'])
            ->add('description', null, ['label' => 'meeting_task_description'])
            ->add('date', 'sonata_type_date_picker', ['label' => 'do_date',
                'required'=>false,
                'dp_pick_time'=>true,
                'format'=>'yyyy/MM/dd H:m:s']
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MainBundle\Entity\MeetingTask'
        ]);
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'meeting_task';
    }
}