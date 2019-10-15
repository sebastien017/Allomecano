<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Garage;
use App\Form\UserType;
use App\Form\GarageType;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use App\Service\FileUploadManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


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
     * @Route("/profile/update-password", name="profile_password")
     * 
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder) {

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );
                
                return $this->redirectToRoute('profile', ['id' => $user->getId()]);

            }
        }
        
        return $this->render('security/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile", methods={"GET"})
     */
    public function profile(Request $request, User $user)
    {
        $garage = new Garage;

        // Si l'id de l'utilisateur dans la route ne correspond pas à l'user qui est connecté, on ne l'autorise pas à afficher le profil
        if ($this->getUser()->getId() == $request->get('id'))
        {
            return $this->render('security/profile.html.twig', [
                'user' => $user,
                'garage' => $garage
            ]);
        }
        else {
            // L'id de l'utilisateur connecté ne correspond pas, on redirige l'user à l'accueil
            return $this->redirectToRoute('home');
        }
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

            $this->addFlash(
                'success',
                "Inscription terminée, vous pouvez vous connecter !"
            );
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
         // Si l'id de l'utilisateur dans la route ne correspond pas à l'user qui est connecté, on ne l'autorise pas à modifier le profil
         if ($this->getUser()->getId() == $request->get('id'))
         {
            $form = $this->createForm(AccountType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                $imagePath = $fileUploadManager->upload($form['avatar'], $user->getId());
                $user->setAvatar($imagePath);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash(
                    'success',
                    "Votre profil a été mis à jour !"
                );

                return $this->redirectToRoute('profile', ['id' => $user->getId()]);
            }
            return $this->render('security/edit-profile.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        else {
            // L'id de l'utilisateur connecté ne correspond pas, on redirige l'user à l'accueil
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
    /**
     * @Route("/image/delete/{id}", name="delete_image")
     */
    public function deleteImage(Image $image, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $image->getId(), $request->get('_token'))) {
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }
        return $this->redirectToRoute('profile', ['id' => $this->getUser()->getId()]);
    }

     /**
     * @Route("/profile/delete/{id}", name="delete_user")
     */
    public function delete(User $user, Request $request)
    {
        // Si l'id de l'utilisateur dans la route ne correspond pas à l'user qui est connecté, on ne l'autorise pas à supprimer le compte
        if ($this->getUser()->getId() == $request->get('id'))
        {
            if($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
                $session = $this->get('session');
                $session = new Session();
                $session->invalidate();
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();

            }
            return $this->redirectToRoute('home');
        }
        else {
            // L'id de l'utilisateur connecté ne correspond pas, on redirige l'user à l'accueil
            return $this->redirectToRoute('home');
        }
    }


    /**
     * @Route("/signup/garage/{id}", name="signup_garage", methods={"GET", "POST"})
     */
    public function signupGarage(User $user, Request $request, TokenStorageInterface $ts, FileUploadManager $fileUploadManager)
    {
        // Vérification si l'utilisateur qui s'inscrit en tant que garage est bien identique à l'id de l'user connecté
        if ($this->getUser()->getId() == $request->get('id'))
        {
            $garage = new Garage;
            $formGarage = $this->createForm(GarageType::class, $garage);
            $formGarage->handleRequest($request);


            if ($formGarage->isSubmitted() && $formGarage->isValid()){
                $em = $this->getDoctrine()->getManager();

                $garage = $formGarage->getData();
                $garage->setUser($user->setRoles(['ROLE_GARAGE']));

                // Récupération coordonnées gps
                $gps = $garage->getGps();
                $gps = strtr($gps, array('(' => '', ')' => ''));

                // Explode des coordonnées gps
                $gpsCoordsArray = explode(',', $gps, 2);
                $garage->setLat($gpsCoordsArray[0]); 
                $garage->setLng($gpsCoordsArray[1]);

                // $files = $request->files->get('garage')['images'];

                $imagePath = $fileUploadManager->upload($formGarage['avatar'], $garage->getId());
                $garage->setAvatar($imagePath);
                
                $files = $request->files->get('garage')['images'];
                
                /**
                 * @var UploadedFile $file
                 */
                foreach ($files as $file) {
                    $image = new Image();

                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $image->setFilename($filename);

                    $image->setUrl('/uploads/' . $filename);

                    $file->move(
                        $this->getParameter('uploads') ,$filename
                    );

                    $image->setGarage($garage);
                    $garage->addImage($image);

                    $em->persist($image);
                }
                
                $em->persist($garage); 

                $this->addFlash(
                    'success',
                    "Inscription de votre garage terminée !"
                );

                $em->flush();

                $ts->setToken(
                    new PostAuthenticationGuardToken($user, 'main', $user->getRoles())
                );
                // On redirige l'utilisateur sur la page de login
                return $this->redirectToRoute('profile', ['id' => $user->getId()]);
            }
                
        return $this->render('security/signup-garage.html.twig', [
                'formGarage' => $formGarage->createView()
        ]);
        }
        else {
            // L'id de l'utilisateur connecté ne correspond pas, on redirige l'user à l'accueil
            return $this->redirectToRoute('home');
        }
    }

    /**
    * @Route("/edit/{id}/garage/{garage}", name="garageEdit")
    * @ParamConverter("garage", options={"mapping": {"id": "user_id", "garage": "id"}})
    */
    public function editGarage(Request $request, Garage $garage, FileUploadManager $fileUploadManager): Response
    {
        // Si l'id de l'utilisateur dans la route ne correspond pas à l'user qui est connecté, on ne l'autorise pas à éditer le profil
        if ($this->getUser()->getId() == $request->get('id'))
        {
            // $user = new User;
            $formGarage = $this->createForm(GarageType::class, $garage);
            $formGarage->handleRequest($request);

            if ($formGarage->isSubmitted() && $formGarage->isValid()){
                $em = $this->getDoctrine()->getManager();
                $imagePath = $fileUploadManager->upload($formGarage['avatar'], $garage->getId());
                $garage->setAvatar($imagePath);
                $files = $request->files->get('garage')['images'];
                
                /**
                 * @var UploadedFile $file
                 */
                foreach ($files as $file) {
                    $image = new Image();

                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $image->setFilename($filename);

                    $image->setUrl('/uploads/' . $filename);

                    $file->move(
                        $this->getParameter('uploads') ,$filename
                    );

                    $image->setGarage($garage);
                    $garage->addImage($image);

                    $em->persist($image);
                }

                // Récupération coordonnées gps
                $gps = $garage->getGps();
                $gps = strtr($gps, array('(' => '', ')' => ''));

                // Explode des coordonnées gps
                $gpsCoordsArray = explode(',', $gps, 2);
                $garage->setLat($gpsCoordsArray[0]); 
                $garage->setLng($gpsCoordsArray[1]);
                
                $em->persist($garage); 
                $em->flush();

                $this->addFlash(
                    'success',
                    "Votre profil garage a bien été mis à jour !"
                );

                return $this->redirectToRoute('profile', ['id' => $garage->getUser()->getId()]);
            }

         return $this->render('security/edit-garage.html.twig', [
            'garage' => $garage,
            'formGarage' => $formGarage->createView(),
         ]);
         
        }
        else {
            // L'id de l'utilisateur connecté ne correspond pas, on redirige l'user à l'accueil
            return $this->redirectToRoute('home');
        }
    }

}
