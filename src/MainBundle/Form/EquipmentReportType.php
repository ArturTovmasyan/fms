<?php
/**
 * Created by PhpStorm.
 * User: artur
 */
namespace MainBundle\Form;

use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('number', 'integer', ['attr' => ['style' => 'width: 65px']])
            ->add('mechanicState', 'choice', ['label' => false, 'choices' => [true,false], 'choice_label' => false,
                 'expanded' => true, 'multiple' => false])
            ->add('accept', 'choice', ['label' => false, 'choices' => [false,true], 'choice_label' => false,
               'expanded' => true, 'multiple' => false])
            ->add('electricState', 'choice', ['label'=>false, 'choices' => [false,true], 'choice_label' => false,
                'expanded' => true, 'multiple' => false])
            ->add('hidravlik', CheckboxType::class, ['label' => 'hidravlik', 'required' => false])
            ->add('mechanic', CheckboxType::class, ['label' => 'mechanic', 'required' => false])
            ->add('electric', CheckboxType::class, ['label' => 'electric', 'required' => false])
            ->add('name', TextType::class, ['label' => false])
            ->add('code', TextType::class, ['label' => false])
            ->add('date', 'date', ['pattern' => 'dd MMM Y', 'widget'=>'single_text','label' => false ])
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
