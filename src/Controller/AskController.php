<?php

namespace App\Controller;

use App\Entity\Ask;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AskController extends AbstractController
{
    /**
     * @Route("/les-missions", name="asklisting")
     */
    public function index()
    {

        $asks = $this->getDoctrine()->getRepository(Ask::class)->findBy(
            array('status' => '1'),
            array('date' => 'DESC')
        );

        return $this->render('ask/vuelisting.html.twig', [
            'controller_name' => 'AskController',
            'asks' => $asks
        ]);
    }

    
}
