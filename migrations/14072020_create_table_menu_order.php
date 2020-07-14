<?php

use App\Core\Migration\Migration;

class CreateTableMenuOrder extends Migration
{
    public function getTableName(): string
    {
        return 'menu_order';
    }

    public function up(): void
    {
        $this->id();
        $this->unsignedBigInteger('menu');
        $this->unsignedBigInteger('order');
        $this->timestamp();
    }
}