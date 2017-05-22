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
 * Class MeetingScheduleType
 * @package MainBundle\Form
 */
class MeetingScheduleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', null, ['label'=>'meeting_subject'])
            ->add('reporter', null, ['label' => 'reporter']);

    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MainBundle\Entity\MeetingSchedule'
        ]);
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'meeting_schedule';
    }
}