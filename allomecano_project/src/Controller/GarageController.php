<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GarageController extends AbstractController
{
    /**
     * @Route("/garage/{id}", name="garage", methods={"GET"})
     */
    public function showSingleGarage(Garage $garage)
    {

    $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);
        return $this->render('garage/garage.html.twig', [
            'garage' => $garage,
        ]);
    }
    /**
     * @Route("/garages/", name="show_garage_by_service_gps", methods={"POST"})
     */
    public function showGarageByServiceAndGps(Request $request)
    {
        $services = $this->getDoctrine()->getRepository(Service::class);
        // dump($services);
        // exit;
    }

}
