<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index(\Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('greg240691@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'mail/mail.html.twig'
            ),
            'text/html'
        )
    ;

    $mailer->send($message);

    return $this->render('mail/index.html.twig', [
        'controller_name' => 'MailController',
    ]);
}
}
