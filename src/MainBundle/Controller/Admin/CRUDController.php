<?php

namespace MainBundle\Controller\Admin;

use MainBundle\Entity\Equipment;
use MainBundle\Entity\EquipmentReport;
use MainBundle\Form\EquipmentReportType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CRUDController extends Controller
{
    /**
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction()
    {
        //get request
        $request = $this->getRequest();
        $listIds = null;

        //get current route
        $uri = $request->getUri();
        $path = parse_url($uri);
        $path = explode('/',$path['path']);

        if(end($path) == 'list') {
            $key = count($path) -2;
            $path = $path[$key];

            //generate custom list ids
            $listIds = $this->generateListId($path);
        }

        //save cookie
        $response = null;

        if($path == 'equipment') {
            $this->listFilterChangeByCookie($request);
        }

        $this->admin->checkAccess('list');

        $preResponse = $this->preList($request);
        if ($preResponse !== null) {
            return $preResponse;
        }

        if ($listMode = $request->get('_list_mode')) {
            $this->admin->setListMode($listMode);
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        //set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        //set listIds data in request
        $request->request->set('listIds', $listIds);

        return $this->render($this->admin->getTemplate('list'), array(
            'action' => 'list',
            'form' => $formView,
            'datagrid' => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ), $response, $request);
    }

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

        return $this->render('MainBundle:Admin/Custom:equipment_report.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * This action is used to show equipment filling status
     *
     * @return Response
     */
    public function equipmentFillingAction()
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

        return $this->render('MainBundle:Admin/Custom:equipment_filter_filling.html.twig', ['pagination' => $pagination]);
    }

    /**
     * This function is used to rule equipment list filter by cookie
     *
     * @param Request $request
     */
    private function listFilterChangeByCookie(Request $request)
    {
        //get field show data
        $formData = $request->request->all();

        //get cookies data
        $cookies = $this->getRequest()->cookies;

        if ($formData || (count($formData) == 1 && $formData['hidden'])) {
            if ($cookies->has('EQUIPMENT_FILTERS')) {
                $cookies->remove('EQUIPMENT_FILTERS');
            }

            unset($formData['hidden']);

            //save cookies
            $formData = serialize($formData);
            $response = new Response();
            $response->headers->setCookie(new Cookie('EQUIPMENT_FILTERS', $formData));
            $response->send();
            $request->cookies->set('EQUIPMENT_FILTERS', $formData);
        }
    }

    /**
     * This function is used to generate show id in equipment
     *
     * @param $path
     * @return mixed
     */
    public function generateListId($path)
    {
        //get entity manager
        $em = $this->get('doctrine')->getManager();
        $connection = $em->getConnection();

        //generate sql query
        $sql = "SELECT eq.id, @ROW := @ROW + 1 AS row FROM ".$path." as eq 
                JOIN (SELECT @ROW := 0) as r 
                ORDER BY eq.id
                ";

        $query = $connection->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();

        return $results;

    }
}