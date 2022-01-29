<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/send-mail', name: 'sendMail', methods: ['POST'])]
    public function sendMail(Request $request, MailerInterface $mailer): Response
    {
        $message = $request->request->get('message');

        $email = (new Email())
            ->from('rabbitmq-apprendre-par-la-pratique@gmail.com')
            ->to($request->request->get('email'))
            ->subject($request->request->get('subject'))
            ->html(''.$message.'</p>');

        $mailer->send($email);

        return $this->redirectToRoute('home');
    }
}
