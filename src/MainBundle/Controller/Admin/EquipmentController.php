<?php

namespace MainBundle\Controller\Admin;

use MainBundle\Entity\Equipment;
use MainBundle\Entity\EquipmentReport;
use MainBundle\Form\EquipmentReportType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EquipmentController extends Controller
{
    /**
     * This action is used to create report for equipment
     *
     * @ParamConverter("equipment", class="MainBundle:Equipment")
     * @param Request $request
     * @param Equipment $equipment
     * @return RedirectResponse|Response
     */
    public function equipmentReportAction(Request $request, Equipment $equipment)
    {
        //get equipment report
        $report = $equipment->getReport();

        //check if report not exist
        if(!$report) {
            $report = new EquipmentReport();
        }

        //get entity manager
        $em = $this->get('doctrine')->getManager();

        // create form
        $form = $this->createForm(new EquipmentReportType(), $report);

        //check if method post
        if ($request->isMethod('POST')) {

            // get data from request
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                $equipment->setReport($report);
                $em->persist($equipment);
                $em->flush();

                $tr = $this->container->get('translator');

                //set flush messages
                $this->addFlash('sonata_flash_success', $tr->trans('report_text'));

                return new RedirectResponse($this->admin->generateUrl('list'));
            }
        }

        return $this->render('MainBundle:Admin:equipment_report.html.twig', array(
           'form' => $form->createView(),
        ));
    }

    /**
     * This action is used to show equipment filling status
     *
     * @param Request $request
     * @return Response
     */
    public function equipmentFillingAction(Request $request)
    {
        //get entity manager
        $em = $this->get('doctrine')->getManager();

        //get equipments
        $equipments = $em->getRepository('MainBundle:Equipment')->findAllEquipment();

        // get page count
        $pageCount = $this->getParameter('page_count');

        //get pagination in container
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $equipments,
            $this->get('request')->query->get('page', 1),
            $pageCount
        );

        return $this->render('MainBundle:Admin:equipment_filter_filling.html.twig', ['pagination' => $pagination]);
    }

}