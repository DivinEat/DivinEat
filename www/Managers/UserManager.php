<?php
namespace App\Managers;

use App\core\DB;
use App\models\User;

class UserManager extends DB {
    
    public function __construct(){
        parent::__construct(User::class, 'users');
    }
}