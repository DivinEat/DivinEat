<?php

use App\Core\Migration;

class CreateTableOrders extends Migration
{
    public function getTableName(): string
    {
        return 'orders';
    }

    public function up(): void
    {
        $this->id();
        $this->unsignedBigInteger('user');
        $this->unsignedBigInteger('horaire');
        $this->date('date');
        $this->double('prix');
        $this->timestamp();
    }
}