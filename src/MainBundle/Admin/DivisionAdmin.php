<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DivisionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('type', null, ['show_filter'=>true, 'label'=>'division_type'])
            ->add('subordination', null, ['show_filter'=>true, 'label'=>'subordination'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('type', null, ['label'=>'division_type'])
            ->add('subordination', null, ['label'=>'subordination'])
            ->add('created')
            ->add('orders')
            ->add('headPosition', null, ['label'=>'head_position'])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getSubject()->getId() ? $this->getSubject()->getId() : 0;

        $formMapper
            ->add('name')
            ->add('type', null, ['label'=>'division_type'])
            ->add('subordination', null, [
                'label' => 'subordination',
                'query_builder' => function($query) use ($id) {
                    $result = $query->createQueryBuilder('dv');
                    $result
                        ->select('d')
                        ->from('MainBundle:Division', 'd')
                        ->where('d.id != :id')
                        ->setParameter(':id', $id);

                    return $result;
                }
            ])
            ->add('created','sonata_type_date_picker', ['required'=>false])
            ->add('orders')
            ->add('headPosition', null, ['label'=>'head_position'])
            ->add('post', 'sonata_type_collection', [
                'label'=>false,
                'btn_add' => 'Ավելացնել հաստիք'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('type', null, ['label'=>'division_type'])
            ->add('subordination', null, ['label'=>'subordination'])
            ->add('created')
            ->add('orders')
            ->add('headPosition', null, ['label'=>'head_position'])
        ;
    }

//    public function preUpdate($object)
//    {
//        $this->prePersist($object);
//    }
//
//    /**
//     * @param mixed $object
//     */
//    public function prePersist($object)
//    {
//        // get product route card
//        $posts = $object->getPost();
//
//        // if product route card is exist
//        if($posts) {
//
//            foreach($posts as $post)
//            {
//                if(!$post->getId() || !$posts->contains($object)) {
//                    $post->setDivision($object);
//                }
//            }
//        }
//    }

}
