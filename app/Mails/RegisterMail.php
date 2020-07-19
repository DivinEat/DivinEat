<?php

namespace App\Mails;

use App\Core\Mail;
use App\Core\Routing\Router;
use App\Managers\ConfigurationManager;

class RegisterMail extends Mail
{
    protected function initiateSender(): void
    {
        $this->setFrom(current((new ConfigurationManager)
            ->findBy(['libelle' => 'email']))->getInfo());
    }

    protected function initiateSubject(string $subject = null): void
    {
        $configuration = current((new ConfigurationManager)
            ->findBy(['libelle' => 'nom_du_site']));

        $this->Subject = 'Bienvenue sur ' . $configuration->getInfo();
    }

    protected function initiateBody(string $body = null): void
    {
        $this->msgHTML('Pour activer votre compte merci de cliquer sur ce <a href="' .
            Router::getRouteByName('auth.register.token', [$body])->getUrl(). '">lien</a>.');
    }
}