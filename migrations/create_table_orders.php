<?php

use App\Core\Migration\Migration;

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
        $this->bool('surPlace');
        $this->string('status', 255, ['default' => 'En cours']);
        $this->timestamp();
    }
}