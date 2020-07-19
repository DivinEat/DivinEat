<?php

namespace App\Mails;

use App\Core\Mail;
use App\Core\Routing\Router;
use App\Managers\ConfigurationManager;

class PasswordMail extends Mail
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

        $this->Subject = $configuration->getInfo() . ' - Mot de passe oublié';
    }

    protected function initiateBody(string $body = null): void
    {
        $this->msgHTML('Pour modifier votre mot de passe cliquer <a href="' .
            Router::getRouteByName('auth.show-new-password', [$body])->getUrl() .'">ici</a>');
    }
}