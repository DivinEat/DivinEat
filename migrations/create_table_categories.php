<?php

use App\Core\Migration\Migration;

class CreateTableCategories extends Migration
{
    public function getTableName(): string
    {
        return 'categories';
    }

    public function up(): void
    {
        $this->id();
        $this->string('name');
        $this->string('slug');
        $this->timestamp();
    }
}