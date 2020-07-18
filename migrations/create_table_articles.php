<?php

use App\Core\Migration\Migration;

class CreateTableArticles extends Migration
{
    public function getTableName(): string
    {
        return 'articles';
    }

    public function up(): void
    {
        $this->id();
        $this->string('title');
        $this->string('slug');
        $this->text('content');
        $this->unsignedBigInteger('categorie', ['default' => 1]);
        $this->bool('publish', ['default' => 1]);
        $this->unsignedBigInteger('author');
        $this->timestamp();
    }
}