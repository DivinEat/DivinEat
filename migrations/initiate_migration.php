<?php

use App\Core\Migration;

class InitiateMigration extends Migration
{
    public function getTableName(): string
    {
        return 'migrations';
    }

    public function up(): void
    {
        $this->id();
        $this->string('migration_name');
        $this->date('migrated_at');
    }
}