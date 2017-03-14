<?php
/**
 * Created by PhpStorm.
 * User: artur
 */

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class EquipmentReportType
 * @package MainBundle\Form
 */
class EquipmentReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tags', CheckboxType::class, ['label' => 'admin.label.name.tags', 'required' => false])
            ->add('successStory', CheckboxType::class, ['label' => 'admin.label.name.success_story', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('comment', CheckboxType::class, ['label' => 'admin.label.name.comment', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('user', CheckboxType::class, ['label' => 'admin.label.name.user', 'required' => false, 'attr' => ['checked' => 'checked']])
        ;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'equipment_report';
    }
}
