<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Entity\Visit;
use App\Entity\User;
use App\Form\VisitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/planning/{id}/", name="edit_planning", methods={"GET", "POST"})
     */
    public function editPlanning(Garage $garage, Request $request)
    {
        $user= new User;
        $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);
        $visit = new Visit;

        $form = $this->createForm(VisitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visit = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
            return $this->redirectToRoute('edit_planning',['id' => $garage->getId()]);
        }
        return $this->render('planning/edit-planning.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
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
