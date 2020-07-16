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
        $this->string('token', 255, ['nullable' => true]);
        $this->bool('status', ['default' => false]);
        $this->unsignedBigInteger('role');
        $this->timestamp();
    }
}