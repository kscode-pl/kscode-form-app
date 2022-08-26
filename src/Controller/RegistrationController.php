<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    private Request $request;
    private UserPasswordHasherInterface $userPasswordHasher;
    private UserAuthenticatorInterface $userAuthenticator;
    private AppAuthenticator $authenticator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
        EntityManagerInterface $entityManager
    )
    {
        $this->request = $request;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userAuthenticator = $userAuthenticator;
        $this->authenticator = $authenticator;
        $this->entityManager = $entityManager;
    }


    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_panel');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->userAuthenticator->authenticateUser(
                $user,
                $this->authenticator,
                $this->request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
