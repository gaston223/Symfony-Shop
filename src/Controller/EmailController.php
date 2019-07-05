<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     * @param Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(\Swift_Mailer $mailer)
    {
        // Création du mail
        $mail = new \Swift_Message();
        $mail->setSubject('Envoi de mail depuis SF4');
        $mail->setFrom('g.coulibalyy@gmail.com');
        $mail->setTo('koulou1er@gmail.com');
        $mail->setBody(
            $this->renderView('email/modèle.html.twig'),
            'text/html'
        );
        // Envoi du mail
        $mailer->send($mail);
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
