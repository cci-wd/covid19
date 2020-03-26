<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homepage()
    {
        return $this->render('pages/home.html.twig', [
            'controller_name' => '',
        ]);
    }

    /**
     * @Route("/security", name="security")
     */
    public function securityrules()
    {
        return $this->render('pages/security.html.twig', [
            'controller_name' => '',
        ]);
    }

}
