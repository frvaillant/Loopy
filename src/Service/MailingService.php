<?php

namespace App\Service;

use App\Entity\Patient;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

class MailingService
{
    private ContainerInterface $container;

    private Environment $twig;

    private MailerInterface $mailer;

    public function __construct(ContainerInterface $container, Environment $twig, MailerInterface $mailer)
    {
        $this->container = $container;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }
    const MAIL_SUBJECT = 'Loopy ne se sent pas très bien';

    public function emailAlert(Patient $patient, $context = 'up')
    {
        $email = (new TemplatedEmail())
            ->from($this->container->getParameter('mailer_from'))
            ->to($patient->getEmail())
            ->subject(self::MAIL_SUBJECT)

            ->htmlTemplate('mail/mail.html.twig')

            ->context([
                'patient' => $patient,
                'context' => $context
            ]);
        $this->mailer->send($email);
    }

    public function newPatient(Patient $patient)
    {
        $subject = 'Dr' . $patient->getDoctor()->getSurname() . 'vous invite sur la plateform Loopy';
        $email = (new TemplatedEmail())
            ->from($this->container->getParameter('mailer_from'))
            ->to($patient->getEmail())
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate('mail/inscription.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'patient' => $patient,
            ]);
        $this->mailer->send($email);
    }

    public function emailToParents($request, $filesName)
    {
        $email = (new TemplatedEmail())
            ->from($this->container->getParameter('mailer_from'))
            ->to('emailbidon@bidon.fr')
            ->subject($request->get('subject'))
            ->htmlTemplate('mail/message.html.twig')
            ->attachFromPath($this->container->getParameter('files_directory') . '/' . $filesName)
            ->context([
                'subject' => $request->get('subject'),
                'content' => $request->get('content'),
            ]);
        $this->mailer->send($email);
    }
}
