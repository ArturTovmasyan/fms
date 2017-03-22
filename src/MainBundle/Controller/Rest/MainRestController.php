<?php

namespace MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use MainBundle\Entity\SparePartImages;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\EntryPoint\RetryAuthenticationEntryPoint;

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
        if($className == 'rubber') {

            if (!is_null($class = $object->getRubberMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'metal') {

            if (!is_null($class = $object->getMetalMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'conductive') {

            if (!is_null($class = $object->getConductiveMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'illiquid') {

            if (!is_null($class = $object->getIlliquidMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'household') {

            if (!is_null($class = $object->getHouseholdMaterials()))
            {
                $class->removeImage($object);
            }
        }

        elseif($className == 'prepack') {

            if (!is_null($class = $object->getPrepackMaterial()))
            {
                $class->removeImage($object);
            }
        }
        else{
            return new Response("$className class name not found", Response::HTTP_NOT_FOUND);
        }

        $em->remove($object);
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

        if($className == 'equipment') {

            $object = $em->getRepository('MainBundle:EquipmentImage')->find($id);

            if (!is_null($class = $object->getEquipment())) {
                $class->removeImage($object);
            } else{
                $this->preRemove($object);
            }

        } elseif($className == 'tools') {

            $object = $em->getRepository('MainBundle:ToolImages')->find($id);

            if (!is_null($class = $object->getTool())) {
                $class->removeImage($object);
            } else{
                $this->preRemove($object);
            }

        } elseif($className == 'sparepart') {

            $object = $em->getRepository('MainBundle:SparePartImages')->find($id);

            if (!is_null($class = $object->getSparePart())) {
                $class->removeImage($object);
            }
            else{
                $this->preRemove($object);
            }
        }
        else{
            return new Response("$className class name not found", Response::HTTP_NOT_FOUND);
        }

        $em->remove($object);
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
     * @return Response
     */
    public function postSparePartFileAction(Request $request)
    {
        //get fms service
        $fmsService = $this->container->get('fms_service');

        //get files in request
        $files = $request->files->get('file');

        //get entity manager
        $em = $this->getDoctrine()->getManager();

        //set empty array data
        $data = [];

        if(is_array($files)) {

            //upload files and create image object
            foreach ($files as $file)
            {
              $newImage = new SparePartImages();
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
        $files = $em->getRepository($repository)->findFiles($className, $id);

        return $files;
    }

}