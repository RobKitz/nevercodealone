<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('pages/influencer-db.html.twig');
    }
}