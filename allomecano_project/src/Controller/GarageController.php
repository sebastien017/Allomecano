<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class GarageController extends AbstractController
{
    /**
     * @Route("/garage/{id}", name="garage", methods={"GET"})
     */
    public function showSingleGarage(Garage $garage)
    {

    $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);

    // Récupération des coordonnées gps
    $gps = $garage->getGps();

    // On retire les parenthèses
    $gps = strtr($gps, array('(' => '', ')' => ''));

    // Explode des coordonnées pour avoir un array de LAT et LNG
    $gpsCoordsArray = explode(',', $gps, 2);
    $latitude = $gpsCoordsArray[0];
    $longitude = trim($gpsCoordsArray[1]);
        return $this->render('garage/garage.html.twig', [
            'zoomLatitude' => $latitude,
            'zoomLongitude' => $longitude,
            'garage' => $garage,
        ]);
    }

/**
     * @Route("/garages/", name="show_garage_by_service_gps", methods={"POST"})
     */
    public function showGarageByServiceAndGps(Request $request)
    {
        // Récupération de l'adresse
        $address = $request->request->get('address');
        // Récupération coordonnées gps
        $gps = $request->request->get('gps');
        $gps = strtr($gps, array('(' => '', ')' => ''));

        // Explode des coordonnées gps
        $gpsCoordsArray = explode(',', $gps, 2);
        $latitude = $gpsCoordsArray[0];
        $longitude = trim($gpsCoordsArray[1]);

        // ID du service
        $service_search = $request->request->get('service_search');
        $serviceID = $service_search['name'];

        $garagesJson = $this->getDoctrine()->getRepository(Garage::class)->getGarages();
      
        return $this->render('garage/search_results.html.twig', [
             'zoomLatitude' => $latitude,
             'zoomLongitude' => $longitude,
             'garages' => $garagesJson
        ]);
        
        $services = $this->getDoctrine()->getRepository(Service::class);
        // dump($services);
        // exit;
    }
}