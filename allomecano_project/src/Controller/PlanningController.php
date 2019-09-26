<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/planning", name="edit_planning", methods={"GET", "POST"})
     */
    public function editPlanning()
    {
        return $this->render('planning/edit-planning.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
    }

    /**
     * @Route("/reservation", name="reservation", methods={"GET", "POST"})
     */
    public function showPlanningByGarage()
    {
        return $this->render('planning/reservation.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
    }

    /**
     * @Route("/reservation/confirm", name="reservation_confirm", methods={"GET", "POST"})
     */
    public function validatePlanning()
    {
        return $this->render('planning/reservation-confirm.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
    }

    /**
     * @Route("/reservation/success", name="reservation_success", methods={"GET", "POST"})
     */
    public function reservationSuccess()
    {
        return $this->render('planning/reservation-success.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
    }
}
