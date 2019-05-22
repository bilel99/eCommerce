<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{

    /**
     * @var
     */
    private $mailer;

    /**
     * @var
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('contact'))
            ->setFrom('noreply@contact.fr')
            ->setTo('contact@contact.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->twig->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}