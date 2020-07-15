<?php

namespace App\Mails;

use App\Core\Mail;
use App\Managers\ConfigurationManager;

class RegisterMail extends Mail
{
    protected function initiateSender(): void
    {
        $this->setFrom('contact@divineat.fr');
    }

    protected function initiateSubject(string $subject = null): void
    {
        $configuration = current((new ConfigurationManager)
            ->findBy(['libelle' => 'nom_du_site']));

        $this->Subject = 'Bienvenue sur ' . $configuration->getInfo();
    }

    protected function initiateBody(string $body = null): void
    {
        $this->htmlTemplate('register');
    }
}