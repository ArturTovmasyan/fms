<?php

namespace MainBundle\Admin;

use MainBundle\Form\Type\SparePartMultipleFileType;
use MainBundle\Traits\FmsAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SparePartAdmin extends Admin
{
    use FmsAdmin;

    /**
     * override list query
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface */

    public function createQuery($context = 'list')
    {
        // call parent query
        $query = parent::createQuery($context);
        // add selected
        $query->addSelect('v, pw, eq, im');
        $query->leftJoin($query->getRootAlias() . '.vendors', 'v');
        $query->leftJoin($query->getRootAlias() . '.placeWarehouse', 'pw');
        $query->leftJoin($query->getRootAlias() . '.equipment', 'eq');
        $query->leftJoin($query->getRootAlias() . '.images', 'im');

        return $query;
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin:fms_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('vendors')
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('created', 'date', array('widget' => 'single_text'))
            ->add('images', null, ['template' => 'MainBundle:Admin:fms_image_show.html.twig', 'label'=>'files'])
        ;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('vendors')
            ->add('equipment', null, array(
                'label' => 'equipment',
                'query_builder' => function($query)  {
                    $result = $query->createQueryBuilder('sp');
                    $result
                        ->select('eq', 'sps')
                        ->from('MainBundle:Equipment','eq')
                        ->leftJoin('eq.sparePart', 'sps')
                        ->where('eq.type = :type')
                        ->setParameter(':type', 1);

                    return $result;
                }
            ))

            ->add('description', 'ckeditor')
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('size', 'choice', array('label' => 'size', 'choices' => array(
                    "Կգ",
                    "Մետր",
                    "Հատ",
                    "Կոմպլեկտ",
                    "Լիտր")))
//            ->add('spare_part_multiple_file', SparePartMultipleFileType::class, ['label'=>'files'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('vendors.name', null, array('show_filters' => true))
            ->add('equipment.id', null, array('label' => 'equipment', 'show_filters' => true))
            ->add('description', null, array('show_filters' => true))
            ->add('actualCost', null, array('label' => 'actual_cost', 'show_filters' => true))
            ->add('balanceCost', null, array('label' => 'balance_cost', 'show_filters' => true))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('vendors')
            ->add('equipment', null, array('label' => 'equipment'))
            ->add('getStringSize', null, array('label' => 'size'))
            ->add('actualCost', null, array('label' => 'actual_cost'))
            ->add('balanceCost', null, array('label' => 'balance_cost'))
            ->add('placeWarehouse', null, array('label' => 'place_warehouse'))
            ->add('countInWarehouse', null, array('label' => 'counts_in_warehouse'))
            ->add('size', 'choice', array('label' => 'size', 'choices' => array(
                "Կգ",
                "Մետր",
                "Հատ",
                "Կոմպլեկտ",
                "Լիտր")))
            ->add('getSparePartImages', null, ['template' => 'MainBundle:Admin:fms_image_list.html.twig', 'label'=>'files'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->prePersist($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        //set relation for object and images
        $images = $this->getImages();
        $this->addImages($object, $images);
    }

    /**
     * This function is used to get images by id
     *
     * @return array
     */
    public function getImages()
    {
        //get images by ids
        $request = $this->getRequest();
        $uniqId = $this->getUniqid();
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $imagesIds = $request->request->get($uniqId)['imageIds'];
        $imagesIds = json_decode($imagesIds, true);
        $ids = explode( ',', $imagesIds);
        $images = $em->getRepository('MainBundle:SparePartImages')->findBy(['id'=>$ids]);

        return $images;
    }
}

