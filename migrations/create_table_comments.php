<?php

use App\Core\Migration\Migration;

class CreateTableComments extends Migration
{
    public function getTableName(): string
    {
        return  'comments';
    }

    public function up(): void
    {
        $this->id();
        $this->text('content');
        $this->unsignedBigInteger('user');
        $this->unsignedBigInteger('article');
        $this->bool('hide', ['default' => 0]);
        $this->timestamp();
    }
}