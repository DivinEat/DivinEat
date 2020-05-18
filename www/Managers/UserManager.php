<?php
namespace App\Managers;

use App\core\DB;
use App\models\users;

class UserManager extends DB {
    
    public function __construct(){
        parent::__construct(users::class, 'users');
    }
}