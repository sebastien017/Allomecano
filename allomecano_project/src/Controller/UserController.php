<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile", methods={"GET"})
     */
    public function profile()
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profile/edit/{id}", name="profileEdit", methods={"GET", "POST"})
     */
    public function editProfile()
    {
        return $this->render('user/edit-profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/signup", name="signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        // Traitement du formulaire si envoyé
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données du formulaire
            $user = $form->getData();
            // On ajout le ROLE_USER à notre utilisateur
            $user->setRoles(['ROLE_USER']);
            // On doit encoder le mot de passe avant d'enregistrer l'utilisateur
            $plainPassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            // On utilise l'entity manager pour persister et enregistrer notre objet
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // On redirige l'utilisateur sur la page de login
            return $this->redirectToRoute('signin');
        }

        return $this->render('user/signup.html.twig', [
                'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/signin", name="signin", methods={"GET", "POST"})
     */
    public function signin()
    {
        return $this->render('user/signin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
