<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ServiceController extends AbstractController
{
    /**
     * @Route("/services", name="show_services", methods={"GET"})
     */
    public function showServices()
    {
        return $this->render('service/services.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    /**
     * @Route("/services/{service}", name="show_service", methods={"GET"})
     */
    public function showGarageByService()
    {
        return $this->render('service/service.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}
