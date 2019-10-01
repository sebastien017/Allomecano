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
     * @Route("/garages/", name="show_garage_by_service_gps", methods={"POST"})
     */
    public function showGarageByServiceAndGps(Request $request)
    {
    
        // Récupération de l'adresse
        $address = $request->request->get('address');

        // Récupération coordonnées gps
        $gps = $request->request->get('gps');
        $gps = strtr($gps, array('(' => '', ')' => ''));

        // ID du service
        $service_search = $request->request->get('service_search');
        $serviceID = $service_search['name'];

        dump($request); dump($gps); dump($address); dump($serviceID); exit;

        return $this->render('garage/search_results.html.twig', [
             
        ]);
        
    }
}
