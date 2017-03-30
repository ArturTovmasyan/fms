<?php

namespace MainBundle\Admin;

use MainBundle\Traits\FmsAdmin;
use MainBundle\Traits\Personnel\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonnelAdmin extends AbstractAdmin
{
    use FmsAdmin;
    use Post;

    const imageClassName = 'PersonnelImages';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        // call parent query
        $query = parent::createQuery($context);

        // add selected
        $query->addSelect('im');
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
            ->add('birthDate')
            ->add('created')
            ->add('updated')
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
            ->add('getImagePath', null, ['template' => 'MainBundle:Admin/List:personnel_image_list.html.twig', 'label'=>'person_image'])
            ->add('birthDate', null, ['label'=>'birth_day'])
            ->add('positionDate', null, ['label'=>'position_date'])
            ->add('mobilePhone', null, ['label'=>'mobile_phone'])
            ->add('fixedPhone', null, ['label'=>'fixed_phone'])
            ->add('alternatePhone', null, ['label'=>'alternate_phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('carNumber', null, ['label'=>'car_number'])
            ->add('address', null, ['label'=>'address'])
            ->add('husband', null, ['label'=>'husband'])
            ->add('children', null, ['label'=>'children'])
            ->add('parent', null, ['label'=>'parent'])
            ->add('sister', null, ['label'=>'sister'])
            ->add('brother', null, ['label'=>'brother'])
            ->add('education', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('post', null, ['label'=>'post'])
            ->add('getPersonnelImages', null, ['template' => 'MainBundle:Admin/List:fms_image_list.html.twig', 'label'=>'files'])
            ->add('language', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig', 'label'=>'language'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('created', null, ['label'=>'created'])
            ->add('updated', null, ['label'=>'updated'])
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
        $subject = $this->getSubject();

        //get post id by request
        $postId = $this->getRequest()->query->get('postId');

        //get object id
        $id = $subject ? $subject->getId() : null;

        //get current class name
        $className = $this->getClassnameLabel();

        //generate array fields data
        $langArrayData = $this->generateLanguageArray($subject);
        $compEducationArrayData = $this->generateCompEducationArray($subject);

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['label'=>'person_image', 'required' => false];

        if ($subject && ($webPath = $subject->getDownloadLink())) {

            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getSchemeAndHttpHost().$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<a href='.$subject->getDownloadLink().' target="_blank"><img src="'.$fullPath.'" style="width:100px;height:100px" /></a>';
        }

        $formMapper
            ->tab('global_info')
            ->add('name', null, ['attr'=>['class' => $className.' '. self::imageClassName]])
            ->add('file', 'file', $fileFieldOptions)
            ->add('birthDate', 'sonata_type_date_picker', ['required'=>false, 'label'=>'birth_day'])
            ->add('positionDate', 'sonata_type_date_picker', ['required'=>false, 'label'=>'position_date'])
            ->add('education', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('post', null, ['label'=>'post'])
            ->add('language', 'choice', ['choices'=> $langArrayData, 'required'=>false, 'multiple'=>true, 'label'=>'language'])
            ->add('anotherLang', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_language'],  'label'=>false, 'required'=>false])
            ->add('compKnowledge', 'choice', ['choices'=> $compEducationArrayData, 'required'=>false, 'label'=>'comp_knowledge','multiple'=>true])
            ->add('anotherCompEducation', 'text', ['mapped'=>false, 'attr' => ['class' => 'hidden-field', 'placeholder'=> 'another_comp_knowledge'], 'label'=>false, 'required'=>false])
            ->end()
            ->end()
            ->tab('contact_data')
            ->add('mobilePhone', null, ['label'=>'mobile_phone'])
            ->add('fixedPhone', null, ['label'=>'fixed_phone'])
            ->add('alternatePhone', null, ['label'=>'alternate_phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('carNumber', null, ['label'=>'car_number'])
            ->add('address', null, ['label'=>'address'])
            ->end()
            ->end()
            ->tab('family_data')
            ->add('husband', null, ['label'=>'husband'])
            ->add('children', null, ['label'=>'children'])
            ->add('parent', null, ['label'=>'parent'])
            ->add('sister', null, ['label'=>'sister'])
            ->add('brother', null, ['label'=>'brother'])
            ->add('imageIds', 'hidden', ['mapped'=>false])
            ->add('postId', 'hidden', ['mapped'=>false, 'attr' => ['class' => $postId]])
            ->add('objectId', 'hidden', ['mapped'=>false, 'data'=>$id])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->tab('global_info')
            ->add('name')
            ->add('images', null, ['template' => 'MainBundle:Admin/Show:fms_image_show.html.twig', 'label'=>'files'])
            ->add('birthDate', null, ['label'=>'birth_day'])
            ->add('positionDate', null, ['label'=>'position_date'])
            ->add('education', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('post', null, ['label'=>'post'])
            ->add('language', null, ['label'=>'language', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/Show:post_array_show.html.twig'])
            ->end()
            ->end()
            ->tab('contact_data')
            ->add('mobilePhone', null, ['label'=>'mobile_phone'])
            ->add('fixedPhone', null, ['label'=>'fixed_phone'])
            ->add('alternatePhone', null, ['label'=>'alternate_phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('carNumber', null, ['label'=>'car_number'])
            ->add('address', null, ['label'=>'address'])
            ->end()
            ->end()
            ->tab('family_data')
            ->add('husband', null, ['label'=>'husband'])
            ->add('children', null, ['label'=>'children'])
            ->add('parent', null, ['label'=>'parent'])
            ->add('sister', null, ['label'=>'sister'])
            ->add('brother', null, ['label'=>'brother'])
            ->end()
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
        //check and set array fields data
        $this->checkAndSetLanguages($object);
        $this->checkAndSetCompEducation($object);

        //set image class name
        $imageClassName = self::imageClassName;

        //set relation for object and images
        $images = $this->getImages($imageClassName);

        if($images) {
            $this->addImages($object, $images);
        }

        //get container
        $container = $this->getConfigurationPool()->getContainer();

        //call upload file listener
        $container->get('fms_service')->uploadFile($object);
    }
}
