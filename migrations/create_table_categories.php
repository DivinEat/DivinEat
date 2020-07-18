<?php

use App\Core\Migration\Migration;
use App\Managers\CategorieManager;

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

    public function seeds(): void
    {
        $roleManager = new CategorieManager;
        $roleManager->create(['name' => 'Défaut', 'slug' => 'default']);
    }
}