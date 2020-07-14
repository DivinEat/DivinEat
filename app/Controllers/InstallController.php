<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\Controller;
use App\Core\Migration\MigrationRunner;
use App\Forms\Install\CreateDatabaseForm;
use App\Forms\Install\CreateInformationsForm;

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

    public function showGeneralForm(Request $request, Response $response)
    {
        $form = $response->createForm(CreateInformationsForm::class);

        $response->render("admin.install.general", "account", ["createInformationsForm" => $form]);
    }

    public function storeGeneralForm(Request $request, Response $response)
    {
        $request->setInputPrefix('createInformationsForm_');

        $form = $response->createForm(CreateInformationsForm::class, $user);
        
        if($request->get('pwd') != $request->get('confirmPwd'))
            $form->addErrors(["confirmPwd" => "Les mots de passe ne correspondent pas"]);

        if (false === $form->handle()) {
            return $response->render("admin.install.general", "account", ["createInformationsForm" => $form]);
        }
    }
}