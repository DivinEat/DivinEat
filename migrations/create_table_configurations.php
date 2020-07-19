<?php

use App\Core\Migration\Migration;
use App\Managers\ConfigurationManager;
use App\Managers\ImageManager;

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
        $this->string('info', 255, ['nullable' => 1]);
        $this->timestamp();
    }

    public function seeds(): void
    {
        $configurationManager = new ConfigurationManager();
        $configurationManager->create(['libelle' => 'nom_du_site', 'info' => 'DivinEat']);
        $configurationManager->create(['libelle' => 'email', 'info' => 'contact@delta-mc.fr']);
        $configurationManager->create(['libelle' => 'facebook']);
        $configurationManager->create(['libelle' => 'linkedin']);
        $configurationManager->create(['libelle' => 'instagram']);

        $imageManager = new ImageManager();
        $configurationManager->create([
            'libelle' => 'logo',
            'info' => ($imageManager->create([
                'name' => 'logo.png',
                'path' => 'logo.png'
            ]))->getId()
        ]);
        $configurationManager->create([
            'libelle' => 'banner',
            'info' => ($imageManager->create([
                'name' => 'banner.jpg',
                'path' => 'banner.jpg'
            ]))->getId()
        ]);
        $configurationManager->create([
            'libelle' => 'favicon',
            'info' => ($imageManager->create([
                'name' => 'favicon.ico',
                'path' => 'favicon.ico'
            ]))->getId()
        ]);
    }
}