<?php

namespace App\Controller;

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
    public function indexAction()
    {
        return $this->render('pages/startpage.html.twig');
    }

    /**
     * @Route("/nca-paas-startup/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ncapaasAction()
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
     * @Route("/ncaevents/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ncaeventsAction()
    {
        return $this->render(
            'pages/nca-events.html.twig',
            [
                'title' => '#NCAEvents - Employer Branding für Webdevelopment Jobs als Community Event',
                'description' => 'Gute Webdeveloper suchen gute Arbeitgeber und möchten einen persönlichen Eindruck vom Team und der Technologie bekommen.',
                'smImage' => 'https://nevercodealone.de/unity/nca-paas/nca-paas.jpg'
            ]
        );
    }

    /**
     * @Route("/vorverkauf/")
     */
    public function vorverkaufAction()
    {
        return $this->render('pages/vorverkauf.html.twig');
    }

    /**
     * @Route("/influencerdb/")
     */
    public function influnecerDBAction()
    {
        return $this->render(
            'pages/influencer-db.html.twig'
        );
    }
}
