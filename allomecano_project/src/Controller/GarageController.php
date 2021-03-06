<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Garage;
use App\Entity\Service;
use App\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class GarageController extends AbstractController
{
    /**
     * @Route("/garage/{id}", name="single_garage", methods={"GET", "POST"})
     */
    public function showSingleGarage(Garage $garage)
    {

    $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);
    $visitList = $this->getDoctrine()->getRepository(Visit::class)->findByDateMaxResult($garage);

    // Récupération des coordonnées gps
    $gps = $garage->getGps();

    // On retire les parenthèses
    $gps = strtr($gps, array('(' => '', ')' => ''));

    // Explode des coordonnées pour avoir un array de LAT et LNG
    $gpsCoordsArray = explode(',', $gps, 2);
    $latitude = $gpsCoordsArray[0];
    $longitude = trim($gpsCoordsArray[1]);
        return $this->render('garage/single_garage.html.twig', [
            'zoomLatitude' => $latitude,
            'zoomLongitude' => $longitude,
            'garage' => $garage,
            'visitList' => $visitList,
        ]);
    }

/**
     * @Route("/garages/", name="show_garage_by_service_gps", methods={"POST"})
     */
    public function showGarageByServiceAndGps(Request $request, SessionInterface $session)
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

        $cart = $session->get('service', []);
        $cart[$serviceID] =1;

        // Enregistrement du service selectionné en session
        $session->set('service', $serviceID);

        // dd($session->get('service'));

        $garages = $this->getDoctrine()->getRepository(Garage::class)->getGarages($latitude, $longitude);
      
        return $this->render('garage/search_results.html.twig', [
             'zoomLatitude' => $latitude,
             'zoomLongitude' => $longitude,
             'garages' => $garages,
             'address' => $address
        ]);
        
        $services = $this->getDoctrine()->getRepository(Service::class);
        // dump($services);
        // exit;
    }
}