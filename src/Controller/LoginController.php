<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    private $routeWhenLogged = 'app_calendar';
    #[Route("/login", name: "app_login", methods: ["GET", "POST"])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_calendar');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('user/login-two.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route("/logins", name: "app_logins", methods: ["GET", "POST"])]
    public function index(Request $request, AuthenticationUtils $au): Response
    {


        // if ($this->getUser()) {
        //     return $this->redirectToRoute($this->routeWhenLogged);
        // }

        $error = $au->getLastAuthenticationError();
        $form = $this->createForm(LoginFormType::class);



        return $this->render('user/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $error,
        ]);
    }
}
