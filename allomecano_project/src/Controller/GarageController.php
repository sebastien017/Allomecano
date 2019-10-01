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
<<<<<<< HEAD
        $services = $this->getDoctrine()->getRepository(Service::class);
        // dump($services);
        // exit;
=======
    
        // Récupération de l'adresse
        $address = $request->request->get('address');

        // Récupération coordonnées gps
        $gps = $request->request->get('gps');
        $regex = preg_replace('!\(([^\)]+)\)!', '', $gps);

        // ID du service
        $service_search = $request->request->get('service_search');
        $serviceID = $service_search['name'];

        dump($request); dump($gps); dump($address); dump($serviceID); exit;

        return $this->render('garage/search_results.html.twig', [
             
        ]);
        
>>>>>>> 0c25e8f11b4754dba623b16a0fb6571317103e9b
    }

}
