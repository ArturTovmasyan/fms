<?php

namespace MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
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
            }

        } elseif($className == 'tools') {

            $object = $em->getRepository('MainBundle:ToolImages')->find($id);

            if (!is_null($class = $object->getTool())) {
                $class->removeImage($object);
            }

        } elseif($className == 'sparepart') {

            $object = $em->getRepository('MainBundle:SparePartImages')->find($id);

            if (!is_null($class = $object->getSparePart())) {
                $class->removeImage($object);
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
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Main",
     *  description="This function is used to get workshop type by workshop id",
     *  statusCodes={
     *         200="Returned when file was removed",
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
}