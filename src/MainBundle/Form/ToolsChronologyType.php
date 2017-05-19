<?php

namespace MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ToolsChronologyType
 * @package MainBundle\Form
 */
class ToolsChronologyType extends AbstractType
{
    private $personnelIds;

    public function __construct($personnelIds)
    {
        //get personnel ids
        $this->personnelIds = $personnelIds;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //get personnel ids in constructor
        $personnelIds = $this->personnelIds;

        //generate dynamically chronology forms values in tool admin page
        $generatedFields = function ($event) use ($personnelIds) {

            //get current personnel id
            $currentPersonnelId = $event->getData() ? $event->getData()->getPersonnel()->getId() : null;

            $event->getForm()
                ->add('personnel', null, [
                    'label' => 'tools_person',
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) use ($currentPersonnelId, $personnelIds) {
                        $query = $er->createQueryBuilder('p');
                        $query
                            ->where('(p.disabled = 0 AND p.id NOT IN (:pIds)) OR p.id = :id')
                            ->setParameter('pIds', $personnelIds)
                            ->setParameter('id', $currentPersonnelId);

                        return $query;
                    }
                ])
                ->add('fromDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_from_date'])
                ->add('toDate', 'sonata_type_date_picker', ['label' => 'tools_chronology_to_date']);
        };

        //call form event
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $generatedFields);

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