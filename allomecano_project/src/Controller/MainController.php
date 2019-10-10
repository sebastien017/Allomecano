<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {
        $services = $this->getDoctrine()->getRepository(Service::class)->findAll();
        $form = $this->createForm(ServiceSearchType::class);
        $form->handleRequest($request);

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function showContactForm()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/mentions-legales", name="legalMentions", methods={"GET"})
     */
    public function showLegalMentions()
    {
        return $this->render('home/mentions-legales.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/a-propos", name="aboutUs", methods={"GET"})
     */
    public function aboutUs()
    {
        return $this->render('home/a-propos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/faq", name="faq", methods={"GET"})
     */
    public function showFaq()
    {
        return $this->render('home/faq.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/presentation", name="presentation", methods={"GET"})
     */
    public function showPresentation()
    {
        return $this->render('home/presentation.html.twig', [
            'controller_name' => 'HomeController', 
        ]);
    }
}
