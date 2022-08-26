<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private AuthenticationUtils $authenticationUtils;

    public function __construct(
        AuthenticationUtils $authenticationUtils
    )
    {
        $this->authenticationUtils=$authenticationUtils;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_panel');
         }

        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->redirectToRoute('app_login');
    }
}
