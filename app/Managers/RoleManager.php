<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Role;

class RoleManager extends Manager {
    
    public function __construct(){
        parent::__construct(Role::class, 'roles');
    }
}