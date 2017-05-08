<?php

namespace MainBundle\Form;

use Sonata\AdminBundle\Form\Type\Filter\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\Tests\Fixtures\TypeHinted;

/**
 * Class ToolsChronologytType
 * @package MainBundle\Form
 */
class ToolsChronologytType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personnel', null, ['label' => 'tools_person', 'required' => true])
            ->add('fromDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_from_date'])
            ->add('toDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_to_date']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MainBundle\Entity\ToolsChronology',
            'cascade_validation' => true
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fms_tools_chronology';
    }
}