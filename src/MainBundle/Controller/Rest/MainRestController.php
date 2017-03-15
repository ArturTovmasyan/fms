<?php

namespace MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use MainBundle\Entity\EquipmentImage;
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
     *  description="This function is used to remove file by id",
     *  statusCodes={
     *         201="Returned when file was removed",
     *         404="Returned when file not found",
     *  },
     * )
     *
     * @Rest\Get("/remove-file/{id}", requirements={"id"="\d+"}, name="main_rest_mainrest_removefile", options={"method_prefix"=false})
     * @Security("has_role('ROLE_ADMIN')")
     * @param EquipmentImage $equipmentImage
     * @return Response
     */
    public function removeFileAction(EquipmentImage $equipmentImage, Request $request)
    {
        //get entity manager
        $em = $this->getDoctrine()->getManager();

        if (!is_null($equipment = $equipmentImage->getEquipment()))
        {
            $equipment->removeImage($equipmentImage);
        }

        $em->remove($equipmentImage);
        $em->flush();

        if ($request->get('_route') == 'main_rest_mainrest_removefile' && isset($_SERVER['HTTP_REFERER'])){
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