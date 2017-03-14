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
            ->add('number', CheckboxType::class, ['label' => 'number', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('mechanicState', CheckboxType::class, ['label' => 'mechanic_state', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('electricState', CheckboxType::class, ['label' => 'electric_state', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('hidravlik', CheckboxType::class, ['label' => 'hidravlik', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('mechanic', CheckboxType::class, ['label' => 'mechanic', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('electric', CheckboxType::class, ['label' => 'electric', 'required' => false, 'attr' => ['checked' => 'checked']])
            ->add('accept', CheckboxType::class, ['label' => 'accept', 'required' => false, 'attr' => ['checked' => 'checked']])
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
