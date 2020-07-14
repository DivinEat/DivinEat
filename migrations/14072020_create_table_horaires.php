<?php

use App\Core\Migration\Migration;

class CreateTableHoraire extends Migration
{
    public function getTableName(): string
    {
        return 'horaires';
    }

    public function up(): void
    {
        $this->id();
        $this->string('horaire');
        $this->timestamp();
    }
}