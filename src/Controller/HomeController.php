<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function contact(Request $request)
    {
        $task = new Contact();
        $form = $this->createForm(ContactType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
    
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
