<?php

use App\Core\Migration\Migration;

class CreateTableMenuElements extends Migration
{
    public function getTableName(): string
    {
        return 'menu_elements';
    }

    public function up(): void
    {
        $this->id();
        $this->string('categorie');
        $this->string('nom');
        $this->text('description');
        $this->double('prix');
        $this->timestamp();
    }
}