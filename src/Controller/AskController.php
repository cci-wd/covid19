<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AskController extends AbstractController
{
    /**
     * @Route("/les-missions", name="asklisting")
     */
    public function index()
    {
        return $this->render('ask/vuelisting.html.twig', [
            'controller_name' => 'AskController',
        ]);
    }

    
}
