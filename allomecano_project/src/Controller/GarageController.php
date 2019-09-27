<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    /**
     * @Route("/garage/{garage}", name="garage")
     */
    public function showSingleGarage()
    {
        return $this->render('garage/garage.html.twig', [
            'controller_name' => 'GarageController',
        ]);
    }

    /**
     * @Route("/garages/{service}&{gps}", name="show_garage_by_service_gps", methods={"GET"})
     */
    public function showGarageByServiceAndGps(Request $request)
    {
        $services = $this->getDoctrine()->getRepository(Service::class);
        dump($services);
        exit;
    }
}
