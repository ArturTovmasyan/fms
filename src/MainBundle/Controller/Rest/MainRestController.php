<?php

namespace MainBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use MainBundle\Entity\EquipmentImage;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Prefix("/api/v1.0")
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
     *         200="Returned when file was removed",
     *         404="Returned when file not found",
     *  },
     * )
     *
     * @Rest\Get("/equipment/remove-file/{id}", requirements={"id"="\d+"}, name="main_rest_mainrest_removefile", options={"method_prefix"=false})
     *
     * @param EquipmentImage $equipmentImage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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

        return new Response('', Response::HTTP_OK);
    }
}