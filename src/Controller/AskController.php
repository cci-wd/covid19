<?php

namespace App\Controller;

use App\Entity\Ask;
use App\Form\AskType;
use App\Entity\Answer;
use Cocur\Slugify\Slugify;
use App\Repository\AskRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/mes-missions", name="myask")
     */
    public function myask()
    {   
        $user = $this->getUser()->getId();

        $asks = $this->getDoctrine()->getRepository(Ask::class)->findBy(
            array('user' => $user),
            array('date' => 'DESC')
        );

        return $this->render('ask/mesmissions.html.twig', [
            'controller_name' => 'AskController',
            'asks' => $asks
        ]);
    }
  
    /**
     * @Route("/nouvelle-mission", name="ask_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   
        $slugify = new Slugify();
        $current_user = $this->getUser();
        date_default_timezone_set("Pacific/Noumea");
        $date = date("d-m-Y");
        $ask = new Ask();
        $ask->setUser($current_user);
        $ask->setDate(\DateTime::createFromFormat('d-m-Y', $date));
        $form = $this->createForm(AskType::class, $ask);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $slug = $slugify->slugify($form['title']->getData());
            $ask->setSlug($slug);

            if( $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ask);
                $entityManager->flush();
                return $this->redirectToRoute('myask');
            }

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

    /**
     * @Route("/mission/{slug}", name="ask_show")
     */
    public function show($slug, AskRepository $repo): Response
    {   
        $ask = $repo->findOneBySlug($slug);
        $answers = $this->getDoctrine()->getRepository(Answer::class)->findBy(
            array(
                'ask' => $ask,
            )
        );
        // dd($answer);

        return $this->render('ask/vuedet.html.twig', [
            'controller_name' => 'AskController',
            'ask' => $ask,
            'answers' => $answers
        ]);
    }

    /**
     * @Route("/je-participe/{slug}", name="answer")
     */
    public function answer($slug, AskRepository $repo, MailerInterface $mailer): Response
    {   
        
        if(isset($_POST['content'])) {

            $answer = new Answer();
            $content = $_POST["content"];
            date_default_timezone_set("Pacific/Noumea");
            $date = date("d-m-Y");
            $ask = $repo->findOneBySlug($slug);
            $current_user = $this->getUser();
            $answer->setContent($content);
            $answer->setDate(\DateTime::createFromFormat('d-m-Y', $date));
            $answer->setAsk($ask);
            $answer->setUser($current_user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();

            $confirmation = (new TemplatedEmail())
                ->from('entraide@covid.nc')
                ->to($current_user->getEmail())
                ->subject('Votre demande a été envoyée!')
                ->htmlTemplate('mail/ask.html.twig');

            $notification = (new TemplatedEmail())
                ->from('entraide@covid.nc')
                ->to($ask->getUser()->getEmail())
                ->subject("Demande de participation: " . $ask->getTitle())
                ->htmlTemplate('mail/answer.html.twig')
                ->context([
                    'content' => $content
            ]);

            $mailer->send($confirmation);
            $mailer->send($notification);

            return $this->redirectToRoute('thanks');
        }

        return $this->redirectToRoute('home');
    }
}
