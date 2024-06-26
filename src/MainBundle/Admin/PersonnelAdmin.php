<?php

namespace MainBundle\Admin;

use MainBundle\Entity\Diploma;
use MainBundle\Traits\Personnel\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonnelAdmin extends AbstractAdmin
{
    use Post;

    const imageClassName = 'PersonnelImages';

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

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('birthDate', null, ['label' => 'birth_day'])
            ->add('disabled')
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
            ->add('id', null, ['template'=>'MainBundle:Admin/Custom:custom_id_show.html.twig'])
            ->add('name')
            ->add('getImagePath', null, ['template' => 'MainBundle:Admin/List:personnel_image_list.html.twig', 'label'=>'person_image'])
            ->add('getDiplomaCount', null, ['template' => 'MainBundle:Admin/List:diploma_image_list.html.twig', 'label'=>'diploma'])
            ->add('birthDate', null, ['label'=>'birth_day'])
            ->add('positionDate', null, ['label'=>'position_date'])
            ->add('mobilePhone', null, ['label'=>'mobile_phone'])
            ->add('fixedPhone', null, ['label'=>'fixed_phone'])
            ->add('alternatePhone', null, ['label'=>'alternate_phone'])
            ->add('email', null, ['label'=>'email'])
            ->add('disabled')
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
            ->add('language', null, ['template' => 'MainBundle:Admin/List:post_array_list.html.twig', 'label'=>'language'])
            ->add('compKnowledge', null, ['label'=>'comp_knowledge', 'template' => 'MainBundle:Admin/List:post_array_list.html.twig'])
            ->add('created', null, ['label'=>'created'])
            ->add('updated', null, ['label'=>'updated'])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        //get object id
        $subject = $this->getSubject();
        $id = $subject ? $subject->getId() : null;

        //get post id by request
        $postId = $this->getRequest()->query->get('postId');

        //get related post id
        $relatedPostId = $subject->getPost() ? $subject->getPost()->getId() : null;

        //get the container so the full path to the image can be set
        $container = $this->getConfigurationPool()->getContainer();

        //generate array fields data
        $langArrayData = $this->generateLanguageArray($subject);
        $compEducationArrayData = $this->generateCompEducationArray($subject);
        $fileFieldOptions = ['label'=>'person_image', 'required' => false];

        if ($subject && ($webPath = $subject->getDownloadLink())) {

            //get profile image full path
            $fullPath = $container->get('request')->getSchemeAndHttpHost().$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<a href='.$subject->getDownloadLink().' target="_blank"><img src="'.$fullPath.'" style="width:100px;height:100px" /></a>';
        }

        //get diploma full type
        $diploma = $subject->getDiploma();
        $diplomaWebPath = $diploma ? $diploma->getImagePath() : null;
        $diplomaFieldOptions = ['label'=>'diploma', 'mapped'=>false, 'required'=>false];

        if ($subject && $diplomaWebPath) {

            $diplomaFullPath = $container->get('request')->getSchemeAndHttpHost().$diplomaWebPath;

            // add a 'help' option containing the preview's img tag
            $diplomaFieldOptions['help'] = '<a href='. $subject->getDiploma()->getDownloadLink().' target="_blank"><img src="'.$diplomaFullPath.'" style="width:100px;height:100px" /></a>';
        }

        $formMapper
            ->tab('global_info')
            ->add('name')
            ->add('file', 'file', $fileFieldOptions)
            ->add('diploma', 'file', $diplomaFieldOptions)
            ->add('disabled')
            ->add('birthDate', 'sonata_type_date_picker', ['required'=>false, 'label'=>'birth_day'])
            ->add('positionDate', 'sonata_type_date_picker', ['required'=>false, 'label'=>'position_date'])
            ->add('education', null, ['label'=>'education'])
            ->add('profession', null, ['label'=>'profession'])
            ->add('post', null, [
                'label' => 'post',
                'query_builder' => function($query) use ($id, $relatedPostId)  {
                    $result = $query->createQueryBuilder('p');
                    $result
                        ->select('pt')
                        ->from('MainBundle:Post','pt')
                        ->leftJoin('pt.personnel', 'pe')
                        ->where('pe.id is NULL');

                    if($id) {
                        $result
                            ->orWhere('pt.id = :postId')
                            ->setParameter(':postId', $relatedPostId);
                    }

                    return $result;
                }
            ])
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
            ->add('getImagePath', null, ['template' => 'MainBundle:Admin/Show:person_image_show.html.twig', 'label'=>'person_image'])
            ->add('getDiplomaCount', null, ['template' => 'MainBundle:Admin/Show:diploma_image_show.html.twig', 'label'=>'files'])
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
        //get container
        $fmsService = $this->getConfigurationPool()->getContainer()->get('fms_service');

        //check and set array fields data
        $this->checkAndSetLanguages($object);
        $this->checkAndSetCompEducation($object);

        //get diploma data in form
        $diploma = $this->getForm()->get('diploma')->getData();

        if($object->getDiploma() && (!$diploma)) {
            return;
        } else {
            //create diploma for personnel
            $dip = new Diploma();
            $dip->setFile($diploma);
            $object->setDiploma($dip);
            $fmsService->uploadFile($dip);
        }

        //call upload file listener
        $fmsService->uploadFile($object);
    }
}
