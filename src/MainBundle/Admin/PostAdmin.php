<?php

namespace MainBundle\Admin;

use MainBundle\Traits\FmsAdmin;
use MainBundle\Traits\Personnel\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostAdmin extends AbstractAdmin
{
    use FmsAdmin;
    use Post;

    const imageClassName = 'PostImages';

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
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('postStatus')
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
            ->add('code')
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('postStatus')
            ->add('getStringEducation')
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('language', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('compKnowledge', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('requirement', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig', 'label'=>'post_req'])
            ->add('chief')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
            ->add('getPostImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
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
        $id = $subject ? $subject->getId() : null;

        //get current class name
        $className = $this->getClassnameLabel();

        //generate array fields data
        $langArrayData = $this->generateLanguageArray($subject);
        $compEducationArrayData = $this->generateCompEducationArray($subject);
        $requireArrayData = $this->generateRequirementArray($subject);

        $educationArray = [
            'Բարձրագույն',
            'Միջին մասնագիտական',
            'Միջնակարգ',
            'Առանց սահմանափակման'
        ];


        $formMapper
            ->tab('global_info')
            ->add('name', null, ['attr'=>['class' => $className.' '. self::imageClassName]])
            ->add('code')
            ->add('division', null, ['label'=>'division'])
            ->add('personnel', null, ['label'=>'personnel']);

        $formMapper
            ->add('postStatus')
            ->add('educationStatus', 'choice', ['choices'=> $educationArray, 'required'=>false])
            ->add('language', 'choice', ['choices'=> $langArrayData, 'required'=>false, 'multiple'=>true])
            ->add('anotherLang', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field'], 'label'=>false, 'required'=>false])
            ->add('compKnowledge', 'choice', ['choices'=> $compEducationArrayData, 'required'=>false, 'multiple'=>true])
            ->add('anotherCompEducation', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field'], 'label'=>false, 'required'=>false])
            ->add('requirement', 'choice', ['choices'=> $requireArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'post_req'])
            ->add('anotherRequirement', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field'], 'label'=>false, 'required'=>false])
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('chief')
            ->end()
            ->end()
            ->tab('job_info')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('responsibility', 'ckeditor', ['required'=>false])
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('divisionId', 'hidden', ['mapped'=>false, 'attr' => ['class' => $divisionId]])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id])
            ->end()
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->tab('global_info')
            ->add('id')
            ->add('name')
            ->add('code')
            ->add('personnel', null, ['label'=>'personnel'])
            ->add('postStatus')
            ->add('language', null, ['template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('getStringEducation')
            ->add('profession')
            ->add('age')
            ->add('experience')
            ->add('compKnowledge', null, ['template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('requirement', null, ['template' => 'MainBundle:Admin/Show:post_array_show.html.twig', 'label'=>'post_req'])
            ->add('chief')
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
            ->end()
            ->end()
            ->tab('job_info')
            ->add('workers')
            ->add('functions')
            ->add('powers')
            ->add('obligations')
            ->add('substitutes')
            ->add('poxarinvox')
            ->add('instructions')
            ->add('jobAgreement')
            ->add('postStory')
            ->add('created')
            ->add('updated')
            ->end()
            ->end();
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
        //check and set array fields data
        $this->checkAndSetLanguages($object);
        $this->checkAndSetCompEducation($object);
        $this->checkAndSetRequirement($object);

        //set image class name
        $imageClassName = self::imageClassName;

        //set relation for object and images
        $images = $this->getImages($imageClassName);

        if($images) {
            $this->addImages($object, $images);
        }
    }
}

