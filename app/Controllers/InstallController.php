<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\Controller;
use App\Core\Migration\MigrationRunner;
use App\Forms\Install\CreateDatabaseForm;

class InstallController extends Controller
{
    public function showDatabaseForm(Request $request, Response $response)
    {
        /*$migrationRunner = new MigrationRunner(DB_PREFIXE);
        $migrationRunner->run();*/

        $form = $response->createForm(CreateDatabaseForm::class);

        $response->render("admin.install.database", "account", ["createDatabaseForm" => $form]);
    }

    public function storeDatabaseForm(Request $request, Response $response)
    {
        $request->setInputPrefix('createDatabaseForm_');

        $form = $response->createForm(CreateDatabaseForm::class, $user);

        if (false === $form->handle()) {
            return $response->render("admin.install.database", "account", ["createDatabaseForm" => $form]);
        }
    }
}