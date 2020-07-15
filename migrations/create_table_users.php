<?php

use App\Core\Migration\Migration;

class CreateTableUsers extends Migration
{
    public function getTableName(): string
    {
        return 'users';
    }

    public function up(): void
    {
        $this->id();
        $this->string('firstname');
        $this->string('lastname');
        $this->string('email');
        $this->string('pwd');
        $this->string('token');
        $this->bool('status');
        $this->unsignedBigInteger('role');
        $this->timestamp();
    }
}