<?php

use App\Core\Migration\Migration;

class CreateTablePages extends Migration
{
    public function getTableName(): string
    {
        return 'pages';
    }

    public function up(): void
    {
        $this->id();
        $this->text('data');
        $this->string('title');
        $this->timestamp();
    }
}