<?php

namespace App\Mails;

use App\Core\Mail;
use App\Managers\ConfigurationManager;

class ContactMail extends Mail
{
    protected function initiateSender(): void
    {
        $this->setFrom(current((new ConfigurationManager)
            ->findBy(['libelle' => 'email']))->getInfo());
    }

    protected function initiateSubject(string $subject = null): void
    {
        $this->Subject = $subject;
    }

    protected function initiateBody(string $body = null): void
    {
        $this->msgHTML($body);
    }
}