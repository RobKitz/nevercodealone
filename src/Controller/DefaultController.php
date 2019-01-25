<?php

namespace App\Controller;

use App\Service\YouTubeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render(
            'pages/startpage.html.twig',
            [
                'title' => 'PHP Training, Software-Qualität und soziale Open Source Projekte',
                'description' => 'Never Code Alone Als Sachverständiger für Webdesign und Event Veranstalter Software-Qualität beim Webdesign.',
                'smImage' => 'https://nevercodealone.de/img/never-code-alone-roboter-org.jpg'
            ]
        );
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
                'title' => '#NCAPaaS - Pipeline as a service - Ihr Projekt als Contributer Lösung',
                'description' => 'Never Code Alone wird zum Code Türsteher und lässt nur noch guten Code in Ihr Projekt und stellt ein automatisertes Deployment.',
                'smImage' => 'https://nevercodealone.de/unity/nca-paas/nca-paas.jpg'
            ]
        );
    }

    /**
     * @Route("/employer-branding/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function employerbrandingAction(YouTubeService $youTubeService)
    {

        $videoList = $youTubeService->getItemsFromChannel();

        return $this->render(
            'pages/employer-branding.html.twig',
            [
                'title' => '#NCAEvents - Employer Branding für Webdevelopment Jobs als Community Event',
                'description' => 'Perfektes Employer Branding - Webdeveloper Jobs über Community Events & Social Media Marketing präsentieren',
                'smImage' => 'https://nevercodealone.de/img/employer-branding-facebook-new.jpg',
                'smTwitter' => 'https://nevercodealone.de/img/employer-branding-twitter.jpg',
                'videoList' => $videoList
            ]
        );
    }

    /**
     * @Route("/impressum/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function impressumAction()
    {
        return $this->render(
            'pages/impressum.html.twig',
            [
                'title' => 'Impressum Never Code Alone',
                'description' => 'Das Impressum von Never Code Alone mit Anschrift, Kontakt und Inhalt.',
                'smImage' => 'https://nevercodealone.de/img/never-code-alone-roboter-org.jpg'
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

    /**
     * @Route("/otto/")
     */
    public function ottoAction(Request $request)
    {
        $eventLink = 'https://www.eventbrite.de/e/otto-scala-never-code-alone-event-tickets-48383184407';

        $sourceParam = $this->getSourceParam($request);

        $eventLink .= $sourceParam;

        return $this->render(
            'pages/otto.html.twig',
            [
                'title' => 'OTTO Scala #NCAEvent',
                'description' => 'Scala Live Coding Workshop im Bereich E-Commerce am 29.9. bei OTTO in Hamburg',
                'smImage' => 'https://nevercodealone.de/img/otto/otto-ncaevent-hamburg.png',
                'eventLink' => $eventLink
            ]
        );
    }

    /**
     * @Route("/accenture-interactive/")
     */
    public function accentureInteractiveAction(Request $request)
    {
        $eventLink = 'https://www.eventbrite.de/e/accenture-interactive-java-ncaevent-tickets-55311196277';

        $sourceParam = $this->getSourceParam($request);

        $eventLink .= $sourceParam;

        return $this->render(
            'pages/accenture-interactive.html.twig',
            [
                'title' => 'Accenture Interactive Jav #NCAEvent',
                'description' => 'Java Live Coding Workshop im Bereich E-Commerce am 06.4. bei Accenture Interactive in Dortmund',
                'smImage' => 'https://nevercodealone.de/ncaevents/accenture-interactive/dortmund-skyline.jpg',
                'eventLink' => $eventLink
            ]
        );
    }

    /**
     * @Route("/hall-of-fame/")
     */
    public function hofAction(Request $request)
    {
        $eventLink = 'https://www.eventbrite.de/e/nca-hall-of-fame-event-tickets-50024321091';

        $sourceParam = $this->getSourceParam($request);

        $eventLink .= $sourceParam;

        return $this->render(
            'pages/hall-of-fame.html.twig',
            [
                'title' => '#NCAEvent Hall of Fame - PHP Workshop',
                'description' => 'Hall of Fame Event als PHP Training mit Live Coding und den besten 4 Speakern der #NCAEvents',
                'smImage' => 'https://nevercodealone.de/events/hall-of-fame/nca-hall-of-fame-event.jpg',
                'eventLink' => $eventLink,
                'location' => [
                    'latitude' => '51.3619703',
                    'longtitude' => '6.4157362'
                ]
            ]
        );
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getSourceParam(Request $request): string
    {
        $aff = 'website';

        $queryGet = $request->query->get('aff');
        if ($queryGet !== null && $queryGet !== '') {
            $aff = $queryGet;
        }

        $sourceParam = '?aff=' . $aff;
        return $sourceParam;
    }
}
