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
 * Class ToolsRepairJobType
 * @package MainBundle\Form
 */
class ToolsRepairJobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('fromDate', 'sonata_type_date_picker', ['label' => 'tools_repair_from_date'])
            ->add('toDate', 'sonata_type_date_picker', ['label' => 'tools_repair_to_date']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'MainBundle\Entity\ToolsRepairJob',
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fms_tools_repair_job';
    }
}