<?php

use App\Core\Migration\Migration;
use App\Managers\RoleManager;

class CreateTableRoles extends Migration
{
    public function getTableName(): string
    {
        return 'roles';
    }

    public function up(): void
    {
        $this->id();
        $this->string('libelle');
        $this->timestamp();
    }

    public function seeds(): void
    {
        $roleManager = new RoleManager;
        $roleManager->create(['libelle' => 'Administrateur']);
        $roleManager->create(['libelle' => 'Membre']);
    }
}