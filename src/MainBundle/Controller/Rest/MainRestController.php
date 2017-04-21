<?php

namespace MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use MainBundle\Entity\EquipmentImage;
use MainBundle\Entity\PersonnelImages;
use MainBundle\Entity\PostImages;
use MainBundle\Entity\SparePartImages;
use MainBundle\Entity\ToolImages;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/admin/api/v1.0")
 */
class MainRestController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to remove raw material files by id",
     *  statusCodes={
     *         201="Returned when file was removed",
     *         404="Returned when file or class name not found",
     *  },
     * )
     *
     * @Rest\Get("/remove-material-file/{id}/{className}", requirements={"id"="\d+"}, name="remove_material_files", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @return Response
     * @param $id
     * @param $className
     */
    public function removeMaterialFileAction($id, $className, Request $request)
    {
        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get file object by id
        $object = $em->getRepository('MainBundle:RawMaterialImages')->find($id);

        if(!$object) {
            return new Response('File not found', Response::HTTP_NOT_FOUND);
        }

        //check and remove image entity relations
        if($className == 'RubberMaterials') {

            if (!is_null($class = $object->getRubberMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'MetalMaterials') {

            if (!is_null($class = $object->getMetalMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'ConductiveMaterials') {

            if (!is_null($class = $object->getConductiveMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'IlliquidMaterials') {

            if (!is_null($class = $object->getIlliquidMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'HouseholdMaterials') {

            if (!is_null($class = $object->getHouseholdMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'PrepackMaterials') {

            if (!is_null($class = $object->getPrepackMaterial()))
            {
                $class->removeImage($object);
            }
        }
        else{
            return new Response("$className class name not found", Response::HTTP_NOT_FOUND);
        }

        $em->remove($object);
        $this->preRemove($object);
        $em->flush();

        if ($request->get('_route') == 'remove_material_files' && isset($_SERVER['HTTP_REFERER'])){
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to remove files by id and class name",
     *  statusCodes={
     *         201="Returned when file was removed",
     *         404="Returned when file not found",
     *  },
     * )
     *
     * @Rest\Get("/remove-file/{id}/{className}", requirements={"id"="\d+"}, name="remove_fms_files", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @return Response
     * @param $id
     * @param $className
     */
    public function removeFileAction($id, $className, Request $request)
    {
        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //check if className not send
        if(!$className) {
            new Response('Invalid parameters', Response::HTTP_BAD_REQUEST);
        }

        //generate dynamically class name
        $className = "MainBundle:".$className;
        $object = $em->getRepository($className)->find($id);

        //check objects instanceof
        if($object instanceof EquipmentImage) {

            if (!is_null($class = $object->getEquipment())) {
                $class->removeImage($object);
            }

        } elseif($object instanceof ToolImages) {

            if (!is_null($class = $object->getTool())) {
                $class->removeImage($object);
            }

        } elseif($object instanceof SparePartImages) {

            if (!is_null($class = $object->getSparePart())) {
                $class->removeImage($object);
            }
        }
//        elseif($object instanceof PostImages) {
//
//            if (!is_null($class = $object->getPost())) {
//                $class->removeImage($object);
//            }
//        } elseif($object instanceof PersonnelImages) {
//
//            if (!is_null($class = $object->getPersonnel())) {
//                $class->removeImage($object);
//            }
//        }
        else{
            return new Response("$className class name not found", Response::HTTP_NOT_FOUND);
        }

        $em->remove($object);
        $this->preRemove($object);
        $em->flush();

        if ($request->get('_route') == 'remove_fms_files' && isset($_SERVER['HTTP_REFERER'])){
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $object
     */
    public function preRemove(&$object)
    {
        // get origin file path
        $filePath = $object->getAbsolutePath() . $object->getFileName();

        // check file and remove
        if (file_exists($filePath) && is_file($filePath)){
            unlink($filePath);
        }
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get workshop type by workshop id",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         201="No content",
     *         403="Forbidden",
     *  },
     * )
     *
     * @Rest\Get("/equipment/type/{workshopId}", requirements={"workshopId"="\d+"}, name="main_rest_mainrest_getequipmenttype", options={"method_prefix"=false})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     * @param $workshopId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @return Response
     */
    public function getEquipmentTypeAction($workshopId)
    {
        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get workshop types
        $workshopTypes = $em->getRepository('MainBundle:WorkshopType')->findByWorkshopId($workshopId);

        return $workshopTypes;
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to upload multiple files",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         403="Forbidden",
     *  },
     * )
     *
     * @Rest\Post("/multiple-files/upload", name="main_rest_mainrest_postuploadmultiplefile", options={"method_prefix"=false})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postSparePartFileAction(Request $request)
    {
        //get fms service
        $fmsService = $this->container->get('fms_service');

        //get data in request
        $files = $request->files->get('file');
        $className = $request->request->get('className');

        //check if className not send
        if(!$className) {
            new Response('Invalid parameters', Response::HTTP_BAD_REQUEST);
        }

        //generate dynamically class name
        $className = "MainBundle\\Entity\\".$className;

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //set empty array data
        $data = [];

        if(is_array($files)) {

            //upload files and create image object
            foreach ($files as $file)
            {
                $newImage = new $className();
                $newImage->setFile($file);
                $fmsService->uploadFile($newImage);

                $em->persist($newImage);
                $em->flush();

                $data['id'][] = $newImage->getId();
                $data['name'][] = $newImage->getFileOriginalName();
            }

            return $data;
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get related files by class name",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         404="Bad request",
     *         403="Forbidden"
     *  },
     * )
     *
     * @Rest\Get("/files/{className}/{id}", name="main_rest_mainrest_getfiles", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"files"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param $className
     * @param $id
     * @return Response
     */
    public function getFilesAction($className, $id)
    {
        //check if one is parameters not exist
        if(!$className || !$id) {
            return new Response('Invalid request parameters', Response::HTTP_BAD_REQUEST);
        }

        //generate dynamically repository name
        $repository = 'MainBundle:'.$className;

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get all related files
        $files = $em->getRepository($repository)->findFiles($id);
        $files = reset($files);

        return $files;
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get post history by post id",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         404="Bad request",
     *         403="Forbidden"
     *  },
     * )
     *
     * @Rest\Get("/post-history/{postId}", name="main_rest_mainrest_getposthistory", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @Rest\View()
     * @param $postId
     * @return Response
     */
    public function getPostHistoryAction($postId)
    {
        //check if one is parameters not exist
        if(!$postId) {
            return new Response('Invalid request parameters', Response::HTTP_BAD_REQUEST);
        }

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get all related files
        $files = $em->getRepository('MainBundle:PostHistory')->findByPostId($postId);

        return $files;
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get raw material data by id",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         404="Bad request",
     *         403="Forbidden"
     *  },
     * )
     *
     * @Rest\Post("/raw-expense", name="main_rest_mainrest_getrawexpense", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @Rest\View()
     * @return Response
     */
    public function getRawExpenseAction(Request $request)
    {
        //get content and add it in request after json decode
        $content = $request->getContent();
        $request->request->add(json_decode($content, true));

        $ids = $request->request->get('ids');

        //check if one is parameters not exist
        if(!$ids) {
            return new Response('Invalid request parameters', Response::HTTP_BAD_REQUEST);
        }

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get all related files
        $ramMaterials = $em->getRepository('MainBundle:RawMaterials')->findById($ids);

        return $ramMaterials;
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get category by profession id",
     *  statusCodes={
     *         200="Returned when file was removed",
     *         404="Bad request",
     *         403="Forbidden"
     *  },
     * )
     *
     * @Rest\Get("/profession-category/{id}", name="main_rest_mainrest_getprofessioncategory", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @Rest\View()
     * @param $id
     * @return Response
     */
    public function getProfessionCategoryAction($id)
    {
        //check if id not exist
        if(!$id) {
            return new Response('Invalid request parameter', Response::HTTP_BAD_REQUEST);
        }

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //get all category for profession by id
        $category = $em->getRepository('MainBundle:Professions')->findCategoryByProfId($id);

        return $category;
    }
}