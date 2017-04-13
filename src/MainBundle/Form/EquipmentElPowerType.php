<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EquipmentElPowerType
 * @package MainBundle\Form
 */
class EquipmentElPowerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', TextType::class, ['label'=>'el_power_value'])
            ->add('text', TextType::class, ['label'=>false, 'required'=>false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MainBundle\Entity\ElPower'
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fms_equipment_el_power';
    }
}