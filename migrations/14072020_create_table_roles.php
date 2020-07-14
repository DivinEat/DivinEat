<?php

use App\Core\Migration\Migration;

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
}