<?php

namespace MainBundle\Controller\Admin;

use MainBundle\Form\EquipmentReportType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function equipmentReportAction(Request $request)
    {
        //get entity manager
        $em = $this->get('doctrine')->getManager();

//        $x = $request;

//        $data =
        // create form
        $form = $this->createForm(new EquipmentReportType());

        //check if method post
        if ($request->isMethod('POST')) {

            // get data from request
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

//                $em->flush();

                //set flush messages
                $this->addFlash('sonata_flash_success', 'TEST TEST TEST TEST');
                $this->addFlash('EquipmentReport', 'REPORT FOR EQUIPMENT CREATED');

                return new RedirectResponse($this->admin->generateUrl('list'));
            }
        }

        return $this->render('MainBundle:Admin:equipment_report.html.twig', array(
           'form' => $form->createView(),
        ));
    }

    /**
     * Edit action.
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null)
    {
        //get parent edit action
        $result =  parent::editAction($id = null);

        return $result;
    }

    /**
     * Show action.
     *
     * @param int|string|null $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function showAction($id = null)
    {
        //get parent edit action
        $result =  parent::showAction($id = null);

        return $result;
    }
}