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
        $number = mt_rand(0, 100);

        return $this->render('startpage/index.html.twig', array(
            'number' => $number
        ));
    }
}