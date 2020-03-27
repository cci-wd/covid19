<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
     * @Route("/regle-de-securite", name="securityrules")
     */
    public function securityrules()
    {
        return $this->render('pages/security.html.twig', [
            'controller_name' => '',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(MailerInterface $mailer, Request $request)
    {
        $task = new Contact();
        $form = $this->createForm(ContactType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $message = (new Email())
                ->from('entraide@covid.com')
                ->to($task->getEmail())
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($message);
    
            return $this->redirectToRoute('thanks');
        }

        return $this->render('pages/contact.html.twig', [
            'contact' => $form->createView(),
        ]);
    }

    /**
     * @Route("/merci", name="thanks")
     */
    public function thank(Request $request)
    {

        return $this->render('pages/thanks.html.twig', [
        ]);
    }
}
