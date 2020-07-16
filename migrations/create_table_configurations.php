<?php

use App\Core\Migration\Migration;
use App\Managers\ConfigurationManager;

class CreateTableConfigurations extends Migration
{
    public function getTableName(): string
    {
        return 'configurations';
    }

    public function up(): void
    {
        $this->id();
        $this->string('libelle');
        $this->string('info', 255, ['nullable' => true]);
        $this->timestamp();
    }

    public function seeds(): void
    {
        $configurationManager = new ConfigurationManager();
        $configurationManager->create(['libelle' => 'nom_du_site', 'info' => 'DivinEat']);
        $configurationManager->create(['libelle' => 'email', 'info' => 'contact@divineat.fr']);
        $configurationManager->create(['libelle' => 'facebook']);
        $configurationManager->create(['libelle' => 'linkedin']);
        $configurationManager->create(['libelle' => 'instagram']);
    }
}