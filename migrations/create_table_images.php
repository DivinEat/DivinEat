<?php

use App\Core\Migration\Migration;

class CreateTableImages extends Migration
{
    public function getTableName(): string
    {
        return 'images';
    }

    public function up(): void
    {
        $this->id();
        $this->string('name');
        $this->string('path');
        $this->timestamp();
    }
}