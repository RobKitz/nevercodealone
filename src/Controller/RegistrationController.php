<?php
/**
 * This is a file with php code.
 *
 * @package Rogoit
 * @author  Roland Golla <rolandgolla@gmail.com>
 */

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/community/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setIsActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /**
             * @todo sent mail
             */

            return $this->redirectToRoute('/community/thankyou');
        }

        return $this->render(
            'community/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/community/thankyou", name="user_registration_thankyou")
     */
    public function thankyouAction()
    {
        return $this->render(
            'community/thankyou.html.twig'
        );
    }
}
