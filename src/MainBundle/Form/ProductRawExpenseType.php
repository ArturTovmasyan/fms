<?php

namespace MainBundle\Form;

use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductRawExpenseType
 * @package MainBundle\Form
 */
class ProductRawExpenseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rawMaterials', null)
            ->add('count', NumberType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\ProductRawExpense',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fms_raw_expense_data';
    }
}