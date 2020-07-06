<?php

namespace App\Core;

use App\Managers\UserManager;
use App\Models\User;

class Auth
{
    protected static ?User $user = null;

    public static function saveUser(User $user): void
    {
        $_SESSION['logged_in_user_id'] = $user->getId();
        $_SESSION['logged_in_user_name'] = $user->getFirstname() . ' ' . $user->getLastname();
    }

    public static function getUser(): ?User
    {
        if (null !== self::$user)
            return self::$user;

        if (empty($_SESSION['logged_in_user_id']))
            return null;

        $userManager = new UserManager();
        $user = $userManager->find($_SESSION['logged_in_user_id']);

        if (! $user instanceof User)
        {
            self::unsaveUser();

            return null;
        }

        return self::$user = $user;
    }

    public static function unsaveUser(): void
    {
        unset($_SESSION);
        self::$user = null;

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],$params["httponly"]);
        }

        session_destroy();
    }
}