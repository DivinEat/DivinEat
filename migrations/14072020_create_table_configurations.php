<?php

use App\Core\Migration;

class CreateTableConfigurations extends Migration
{
    public function getTableName(): string
    {
        return 'configurations';
    }

    public function up(): void
    {
        $this->id();
        $this->string('libelle');
        $this->string('info');
        $this->timestamp();
    }
}