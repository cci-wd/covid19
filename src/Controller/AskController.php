<?php

namespace App\Controller;

use App\Entity\Ask;
use App\Form\AskType;
use App\Repository\AskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
  
    /**
     * @Route("/nouvelle-mission", name="ask_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   
        $current_user = $this->getUser();
        date_default_timezone_set("Pacific/Noumea");
        $date = date("d-m-Y");
        $ask = new Ask();
        $ask->setUser($current_user);
        $ask->setDate(\DateTime::createFromFormat('d-m-Y', $date));
        $form = $this->createForm(AskType::class, $ask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ask);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('ask/new.html.twig', [
            'ask' => $ask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edition-mission-{id}", name="ask_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ask $ask): Response
    {
        $form = $this->createForm(AskType::class, $ask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('ask/edit.html.twig', [
            'ask' => $ask,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/delete-mission-private/{id}", name="ask_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ask $ask): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ask->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ask_index');
    }
}
