<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
     * @Route("/mentions-legales", name="mentionslegales")
     */
    public function mentionslegales()
    {
        return $this->render('pages/mentionslegales.html.twig', [
            'controller_name' => '',
        ]);
    }

    /**
     * @Route("/rgpd", name="rgpd")
     */
    public function rgpd()
    {
        return $this->render('pages/rgpd.html.twig', [
            'controller_name' => '',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(MailerInterface $mailer, Request $request)
    {
        $task = new Contact();
        date_default_timezone_set("Pacific/Noumea");
        $task->setDate(new \DateTime());
        $form = $this->createForm(ContactType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $message = (new TemplatedEmail())
                ->from('contact@entraide.nc')
                ->to($task->getEmail())
                ->subject('Message Envoyé!')
                ->htmlTemplate('mail/contact.html.twig')
                ->context([
                    'name' => $task->getName(),
                    'surname' => $task->getSurname(),
                    'tel' => $task->getPhone(),
                    'content' => $task->getContent(),
                ]);




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
