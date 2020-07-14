<?php

use App\Core\Migration\Migration;

class CreateTableMenus extends Migration
{
    public function getTableName(): string
    {
        return 'menus';
    }

    public function up(): void
    {
        $this->id();
        $this->string('nom');
        $this->unsignedBigInteger('entree');
        $this->unsignedBigInteger('plat');
        $this->unsignedBigInteger('dessert');
        $this->double('prix');
        $this->timestamp();
    }
}