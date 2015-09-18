<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Production;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/test")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $producyion = new Production();

        // get entity manager
        $em = $this->getDoctrine()->getManager();

        $producyion->setName("ARTUR");
        $producyion->setDescription("GELLO");
        $producyion->setCode("005");

        $em->persist($producyion);
        $em->flush();

//        $id = $producyion->getId();

//        dump($id);exit;

        return ;
    }
}
