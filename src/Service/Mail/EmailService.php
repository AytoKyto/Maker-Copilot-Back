<?php

namespace App\Service\Mail;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailService
{

    private $mailer;
    private $twig;


    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendEmail(string $to, string $subject, string $template, array $context = []): void
    {

        $htmlTemplate = $this->twig->render($template, $context);


        $email = (new Email())
            ->from('no-reply@maker-copilot.com')
            ->to($to)
            ->subject($subject)
            ->html($htmlTemplate);

        $this->mailer->send($email);
    }
}
