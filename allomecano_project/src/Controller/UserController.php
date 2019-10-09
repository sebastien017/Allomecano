<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Garage;
use App\Form\UserType;
use App\Form\GarageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\FileUploadManager;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/profile/{id}", name="profile", methods={"GET"})
     */
    public function profile(User $user)
    {
        $garage = new Garage;

        return $this->render('security/profile.html.twig', [
            'user' => $user,
            'garage' => $garage
            ]);
    }

    /**
     * @Route("/signup", name="signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder, FileUploadManager $fileUploadManager)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        
        // Traitement du formulaire si envoyé
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données du formulaire
            $user = $form->getData();
            // On ajout le ROLE_USER à notre utilisateur
            $user->setRoles(['ROLE_USER']);

            $imagePath = $fileUploadManager->upload($form['avatar'], $user->getId());
            $user->setAvatar($imagePath);

            // On doit encoder le mot de passe avant d'enregistrer l'utilisateur
            $plainPassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            // On utilise l'entity manager pour persister et enregistrer notre objet
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();
            // On redirige l'utilisateur sur la page de login
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/signup.html.twig', [
                'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/profile/edit/{id}", name="profileEdit")
    */
    public function editProfile(Request $request, User $user, UserPasswordEncoderInterface $encoder, FileUploadManager $fileUploadManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            $imagePath = $fileUploadManager->upload($form['avatar'], $user->getId());
            $user->setAvatar($imagePath);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }
        return $this->render('security/edit-profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

     /**
     * @Route("/profile/delete/{id}", name="delete_user")
     */
    public function delete(User $user, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/signup/garage/{id}", name="signup_garage", methods={"GET", "POST"})
     */
    public function signupGarage(User $user, Request $request)
    {
        $garage = new Garage;
        $formGarage = $this->createForm(GarageType::class, $garage);
        $formGarage->handleRequest($request);


            if ($formGarage->isSubmitted() && $formGarage->isValid()){
                $garage = $formGarage->getData();
                $garage->setUser($user->setRoles(['ROLE_GARAGE']));
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($garage); 
                $em->flush();
                // On redirige l'utilisateur sur la page de login
                return $this->redirectToRoute('profile', ['id' => $user->getId()]);
            }
                
        return $this->render('security/signup-garage.html.twig', [
                'formGarage' => $formGarage->createView()
        ]);
    }

    /**
    * @Route("/edit/{id}/garage/{garage}", name="garageEdit")
    * @ParamConverter("garage", options={"mapping": {"id": "user_id", "garage": "id"}})
    */
    public function editGarage(Request $request, Garage $garage): Response
    {
        // $user = new User;
        $formGarage = $this->createForm(GarageType::class, $garage);
        $formGarage->handleRequest($request);


            if ($formGarage->isSubmitted() && $formGarage->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($garage); 
                $em->flush();
                
                return $this->redirectToRoute('profile', ['id' => $garage->getUser()->getId()]);
            }
        return $this->render('security/edit-garage.html.twig', [
            'garage' => $garage,
            'formGarage' => $formGarage->createView(),
        ]);
    }
}
