<?php

namespace App\Managers;

use App\Core\Manager;
use App\Models\users;


class UserManager extends Manager
{
    public function __construct()
    {
        parent::__construct(users::class, 'users');
    }
} 