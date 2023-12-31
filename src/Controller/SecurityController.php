<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Methode qui gere l'authentification
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUserName = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $lastUserName,
            'error' => $error
        ]);
    }

    /**
     * Methode de deconnexion
     *
     * @return void
     */
    #[Route('/deconnexion', name: 'security.logout', methods: ['GET'])]
    public function logout()
    {
       // nothing to do here
    }
}
