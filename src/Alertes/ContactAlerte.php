<?php

namespace App\Alertes;

use Twig\Environment;
use App\Entity\Contact;

class ContactAlerte{

    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
            $this->mailer = $mailer;
            $this->renderer = $renderer;        
    }
    
    public function alerte(Contact $contact){
        /*
        $message = (new \Swift_Message('Agence:' . $contact->getEquipe()->getNom()))
        ->setFrom('noreply@iapalkot@-gmail.com')
        ->setTo('noreply@anawin-mbomou.org')
        ->setReplyTo($contact->getEmail())
        ->setBody($this->renderer->render(
                // templates/hello/email.txt.twig
                'emails/contact.html.twig', [
                    'contact' => $contact
                ]), 'text/html'
            );
                $this->mailer->send($message);*/
    }
}


