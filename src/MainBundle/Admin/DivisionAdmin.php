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
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MainBundle:Admin/Edit:post_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
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
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('type', null, ['label'=>'division_type'])
            ->add('subordination', null, ['label'=>'subordination'])
            ->add('post', null, ['label'=>'post'])
            ->add('orders', null, ['label'=>'division_order'])
            ->add('headPosition', null, ['label'=>'head_position'])
            ->add('created', null, ['label'=>'created'])
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
        //get division id by request
        $divisionId = $this->getRequest()->query->get('divisionId');
        $subject = $this->getSubject();

        //get object id
        $id = $subject ? $subject->getId() : 0;

        $formMapper
            ->add('type', 'sonata_type_model', ['label'=>'division_type', 'required'=>false])
            ->add('subordination', null, [
                'label' => 'subordination',
                'property'=> 'headPosition',
                'query_builder' => function($query) use ($id) {
                    $result = $query->createQueryBuilder('dv');
                    $result
                        ->select('d')
                        ->from('MainBundle:Division', 'd');

                    if($id) {
                        $result
                            ->where('d.id != :id')
                            ->setParameter(':id', $id);
                    }
                    return $result;
                }
            ])
            ->add('created','sonata_type_date_picker', ['label'=>'created', 'required'=>false])
            ->add('orders', null, ['label'=>'division_order'])
            ->add('headPosition', null, ['label'=>'head_position'])
            ->add('post', null, array('label'=>'post','required'=>false))
            ->add('divisionId', 'hidden', ['mapped'=>false, 'attr' => ['class' => $divisionId]])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('type', null, ['label'=>'division_type'])
            ->add('subordination', null, ['label'=>'subordination'])
            ->add('created', null, ['label'=>'created'])
            ->add('orders', null, ['label'=>'division_order'])
            ->add('headPosition', null, ['label'=>'head_position'])
        ;
    }

    /**
     * @param mixed $division
     */
    public function preUpdate($division)
    {
        $this->prePersist($division);
    }

    /**
     * @param mixed $division
     */
    public function prePersist($division)
    {
        // get product route card
        $posts = $division->getPost();

        // if product route card is exist
        if($posts) {

            foreach($posts as $post)
            {
                $divisions = $post->getDivision();

                if(!$divisions->contains($division)) {
                    $post->addDivision($division);
                }
            }
        }
    }
}
