<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function signup()
    {
        return $this->render('user/signup.html.twig', [
            'controller_name' => 'UserController',
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
