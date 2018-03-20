<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @param Request             $request   This is the request object from symfony.
     * @param AuthenticationUtils $authUtils Tdhajhcj.
     * @Route("/community/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        return $this->render(
            'community/login.html.twig',
            array(
            'last_username' => $lastUsername,
            'error'         => $error,
            )
        );
    }

    /**
     * @Route("/community/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    public function spamProtection(array $data)
    {
        // Validate IP
        if(!$this->validateIp($data['ip'])) {
            return false;
        }

        // Validate post limit

        // Validate message

        // Validate Email


    }

    private function validateIp(string $ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Europe

    }
}