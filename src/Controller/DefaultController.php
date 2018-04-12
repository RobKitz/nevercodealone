<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('pages/startpage.html.twig');
    }

    /**
     * @Route("/nca-paas-startup/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ncapaas()
    {
        return $this->render(
            'pages/nca-paas-startup.html.twig',
            [
                'title' => '#NCAPaaS - Pipeline as a Service - Sachverstand und Infrastruktur für Software-Qualität',
                'description' => 'Continuous Integration Pipeline as a Service mit Sachverstand, Infrastruktur, Codestandards, Codereviews, automatisterten Tests und Builds',
                'smImage' => 'https://nevercodealone.de/unity/nca-paas/nca-paas.jpg'
            ]
        );
    }

    /**
     * @Route("/vorverkauf/")
     */
    public function vorverkauf()
    {
        return $this->render('pages/vorverkauf.html.twig');
    }

    /**
     * @Route("/influencerdb/")
     */
    public function influnecerDB()
    {
        return $this->render(
            'pages/influencer-db.html.twig'
        );
    }

    /**
     * @Route("/api/messages")
     * @Method("POST")
     */
    public function messagesAction(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        if(!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
            return new JsonResponse(
                'doRegistration has not set values',
                401
            );
        }

        $name = $data['name'];
        $email = $data['email'];
        $message = $data['message'];

        if($name === '' || $email === '' || $message === '') {
            return new JsonResponse(
                'doRegistration has empty values',
                400
            );
        }

        $messageEntity = new Message();
        $messageEntity->setName($name);
        $messageEntity->setEmail($email);
        $messageEntity->setMessage($message);
        $messageEntity->setIp($request->server->get('REMOTE_ADDR'));

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($messageEntity);
            $em->flush($messageEntity);

            mail('rolandgolla@gmail.com', 'Kontakt NCA', $email . ' ' . $message);
            $status = 200;
        } catch (\Exception $exception) {
            $status = 500;
        }

        return new JsonResponse(
            'doRegistration',
            $status
        );
    }
}