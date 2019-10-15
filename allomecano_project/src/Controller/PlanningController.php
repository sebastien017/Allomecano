<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\User;
use App\Entity\Visit;
use App\Entity\Garage;
use App\Entity\Comment;
use App\Form\EditVisitType;
use App\Form\VisitType;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PlanningController extends AbstractController
{

    /**
     * @Route("/reservation/success", name="reservation_success", methods={"GET", "POST"})
     */
    public function reservationSuccess(SessionInterface $session)
    {
        $visitId = $session->get('visit_id');

        // Récupération des informations de visit depuis la bdd
        $visit = $this->getDoctrine()->getRepository(Visit::class)->find($visitId);

        $service = $visit->getService();

        // Récupération des informations de visit depuis la bdd
        // $service = $this->getDoctrine()->getRepository(Service::class)->find($serviceId);

        // dd($service);
        return $this->render('planning/reservation-success.html.twig', [
            'visit' => $visit,
            'service' => $service,
            'controller_name' => 'PlanningController',
        ]);
    }

    /**
     * @Route("/planning/{id}/", name="edit_planning", methods={"GET", "POST", "DELETE"})
     */
    public function editPlanning(Garage $garage, Request $request)
    {
        $user= new User;
        $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);
        $visit = new Visit;
        
        $form = $this->createForm(EditVisitType::class);
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
    public function deletePlanning(Request $request, Visit $visit, SessionInterface $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($visit);
            $entityManager->flush();
        }
        return $this->redirectToRoute('edit_planning',['id' => $visit->getGarage()->getId()]);
    }


    /**
     * @Route("/reservation/{id}", name="reservation", methods={"GET", "POST"})
     */
    public function showPlanningByGarage(Request $request, Garage $garage, SessionInterface $session)
    {
        $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);

        $visite = $this->getDoctrine()->getRepository(Visit::class)->findByDate($garage); 

        return $this->render('planning/reservation.html.twig', [
            'garage' => $garage,
            'visite' => $visite,
        ]);
    }


    /**
     * @Route("/reservation/{id}/confirm/", name="reservation_confirm", methods={"GET", "POST"})
     *
     */
    public function validatePlanning(Request $request, Garage $garage, SessionInterface $session)
    {
        // Soit l'ID vient du form showPlanningByGarage
        //   - et on le stocke en session
        // soit il arrive de la session
        //   - on le récupère de la session
        if ($visitId = $request->request->get('visit_id')) {
            // On stocke en session
            $session->set('visit_id', $visitId);
        } else {
            // On lit la session
            $visitId = $session->get('visit_id');
        }

        $selectedService = $session->get('service');

        // Récupération des informations de service depuis la bdd
        $service = $this->getDoctrine()->getRepository(Service::class)->find($selectedService);
        // dd($session->get('cart')['visit_id']);

        // Récupération des informations de visit depuis la bdd
        $visit = $this->getDoctrine()->getRepository(Visit::class)->find($visitId);


        // Récupération des informations de garage depuis la bdd
        $garage = $this->getDoctrine()->getRepository(Garage::class)->find($garage);

        // Récupération de l'id de l'user qui prends le rdv
        $currentUser = $this->getUser();

        // On ajoute les infos à l'objet Visit
        $visit->setService($service)->setUser($currentUser)->setReservationDate(new \DateTime);

        // Création du formulaire associé à $visit pour préremplir les champs du formulaire
        $form = $this->createForm(VisitType::class, $visit);

        // $form->get('service')->setData($selectedService);

        // On relie les données reçues en POST avec le formulaire
        $form->handleRequest($request);

        // Il est nécessaire de persister les données
        // …mais on ne le fait que si le formulaire a été envoyé et que les données dedans sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Les conditions sont remplies : on peut persister les données !
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
            return $this->redirectToRoute('reservation_success');
            // dd('success');
        }

        return $this->render('planning/reservation-confirm.html.twig', [
            'garage' => $garage,
            'visitId' => $visitId,
            'visit' => $visit,
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reservation/history", name="reservation_history", methods={"GET", "POST"})
     */
    public function reservationHistory(Request $request, Visit $visit, ObjectManager $em)
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
