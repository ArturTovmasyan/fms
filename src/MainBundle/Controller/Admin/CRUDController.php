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
            $key = count($path) - 2;
            $path = $path[$key];
            $materials = explode('_', $path);
            $materials = end($materials);

            if($materials == 'materials') {
                $materials = true;
            } else{
                $materials = false;
            }

            //generate custom list ids
            $listIds = $this->generateListId($path, $materials);
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

        return $this->render($this->admin->getTemplate('list'), [
            'action' => 'list',
            'form' => $formView,
            'datagrid' => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ], $response, $request);
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

        return $this->render('MainBundle:Admin/Custom:equipment_report.html.twig', [
            'form' => $form->createView(),
        ]);
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
     * This action is used to get job day count for years
     *
     * @return Response
     */
    public function jobDaysAction()
    {
        //set default data
        $type = CAL_GREGORIAN;
        $jobDays = [];
        $year = date('Y'); // Year in 4 digit 2009 format.


        //generate job days count for each month in current and preview years
        for ($y = $year - 1; $y <= $year; $y++) {

            for ($m = 1; $m <= 12; $m++) {

                $workdaysCount = 0;
                $day_counts = cal_days_in_month($type, $m, $y); // Get the amount of days by years and month

                //loop through all days
                for ($i = 1; $i <= $day_counts; $i++) {

                    $date = $y.'/'.$m.'/'.$i;
                    $getName = date('l', strtotime($date)); //Get day name
                    $dayName = substr($getName, 0, 3); // Trim day name to 3 chars

                    //if not a weekend add sum day
                    if ($dayName != 'Sun' && $dayName != 'Sat') {
                        $workdaysCount ++;
                    }
                }

                $jobDays[$y][$m] = $workdaysCount;
            }
        }

        return $this->render('MainBundle:Admin/Custom:job_day_counts.html.twig', ['days'=> $jobDays]);
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
     * @param bool $materials
     * @return mixed
     */
    public function generateListId($path, $materials = false)
    {
        //get entity manager
        $em = $this->get('doctrine')->getManager();
        $connection = $em->getConnection();

        if($materials) {
            $field = 'eq.code';
        } else {
            $field = 'eq.id';
        }

        //generate sql query
        $sql = "SELECT ".$field.", @ROW := @ROW + 1 AS row FROM ".$path." as eq 
                JOIN (SELECT @ROW := 0) as r 
                ORDER BY eq.id
                ";

        $query = $connection->prepare($sql);
        $query->execute();
        $results = $query->fetchAll();

        return $results;

    }
}