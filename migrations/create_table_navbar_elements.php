<?php

use App\Core\Migration\Migration;

class CreateTableNavbarElements extends Migration
{
    public function getTableName(): string
    {
        return 'navbar_elements';
    }

    public function up(): void
    {
        $this->id();
        $this->string('name');
        $this->unsignedBigInteger('page');
        $this->string('slug');
        $this->timestamp();
    }
}