<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
use App\Form\UserType;

class SecurityController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request)
    {  //creation de l'utilisateur
        $user = new User();
        //creation du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //verification si les donnes sont valide
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            //Hacher le mot de passe
            $user->setPassword($this->passwordEncoder->encodePassword($user,$user->getPassword()));
            //Modifier la date d'inscription
            $user->setDateInscription(new \Datetime());
            //premet d'enregister dans la base de donnes
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //pour envoyer de message succes
            $this->addFlash("message","message de succeés! ");
            return $this->redirectToRoute("app_login"); 
        }
        //
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
        //https://sharemycode.fr/gxv
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
