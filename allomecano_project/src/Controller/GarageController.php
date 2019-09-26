<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
