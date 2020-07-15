<?php

namespace App\Mails;

use App\Core\Mail;

class ContactMail extends Mail
{
    protected function initiateSender(): void
    {
        $this->setFrom('contact.form@divineat.fr');
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