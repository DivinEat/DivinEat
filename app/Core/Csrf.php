<?php

namespace App\Core;

use PHPMailer\PHPMailer\Exception;

class Csrf
{
    public static function generateUserCsrfToken(): string
    {
        $csrfToken = uniqid();

        self::saveCsrfTokenInSession($csrfToken);

        return $csrfToken;
    }

    public static function checkUserCsrfToken(string $csrfToken): bool
    {
        if (! isset($_SESSION['Csrf_token']) || ! isset($_SESSION['Csrf_timestamp']))
            return false;

        $csrfTimestamp = (new \DateTime())->setTimestamp($_SESSION['Csrf_timestamp']);

        return $csrfToken === $_SESSION['Csrf_token']
            && $csrfTimestamp->diff(new \DateTime())->i < 5;
    }

    public static function unsaveCsrfTokenInSession(): void
    {
        if (isset($_SESSION['Csrf_token']))
            unset($_SESSION['Csrf_token']);

        if (isset($_SESSION['Csrf_timestamp']))
            unset($_SESSION['Csrf_timestamp']);
    }

    protected static function saveCsrfTokenInSession(string $csrfToken): void
    {
        self::unsaveCsrfTokenInSession();

        $_SESSION['Csrf_token'] = $csrfToken;
        $_SESSION['Csrf_timestamp'] = (new \DateTime())->getTimestamp();
    }
}