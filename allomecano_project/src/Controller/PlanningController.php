<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Visit;
use App\Entity\Garage;
use App\Entity\Comment;
use App\Form\VisitType;
use App\Form\CommentType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PlanningController extends AbstractController
{
    /**
     * @Route("/planning/{id}/", name="edit_planning", methods={"GET", "POST", "DELETE"})
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
            $visit->setGarage($garage);

            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
            return $this->redirectToRoute('edit_planning',['id' => $garage->getId()]);
        }
        return $this->render('planning/edit-planning.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'garage' => $garage
        ]);
    }

    /**
     * @Route("/visit/delete/{id}", name="visit_delete", methods={"DELETE"})
     */
    public function deletePlanning(Request $request, Visit $visit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($visit);
            $entityManager->flush();
        }
        return $this->redirectToRoute('edit_planning',['id' => $visit->getGarage()->getId()]);
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

    /**
     * @Route("/reservation/{id}", name="reservation_history", methods={"GET", "POST"})
     */
    public function reservationHistroy(Request $request, Visit $visit, ObjectManager $em)
    {
        $visit = $this->getDoctrine()->getRepository(Visit::class)->find($visit);
        
        $comment = new Comment();
        $garage = new Garage();

        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        if($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setGarage($visit->getGarage());
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('reservation_history',['id' => $visit->getId()]);
            
        }
        return $this->render('planning/reservation-history.html.twig', [
            'visit' => $visit,
            'garage' => $garage,
            'formComment' => $formComment->createView()
        ]);
    }

}
