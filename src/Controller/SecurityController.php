<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AccessDecisionManagerInterface $accessDecisionManager, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $token = new UsernamePasswordToken($this->getUser(), 'none', $this->getUser()->getRoles());
            if ($accessDecisionManager->decide($token, ['ROLE_VENDEUR'])) {
                return $this->redirectToRoute('app_produit_index');
            } else{
                return $this->redirectToRoute('app_commande_index');
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
