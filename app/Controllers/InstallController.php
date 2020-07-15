<?php

namespace App\Controllers;

use App\Core\EnvCreator;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\Controller;
use App\Core\Migration\MigrationRunner;
use App\Core\Routing\Router;
use App\Forms\Install\CreateDatabaseForm;
use App\Forms\Install\CreateInformationsForm;
use App\Forms\Install\CreateSMTPForm;
use PHPMailer\PHPMailer\SMTP;

class InstallController extends Controller
{
    public function showDatabaseForm(Request $request, Response $response)
    {
        $form = $response->createForm(CreateDatabaseForm::class);

        $response->render("admin.install.database", "account", ["createDatabaseForm" => $form]);
    }

    public function storeDatabaseForm(Request $request, Response $response)
    {
        $request->setInputPrefix('createDatabaseForm_');

        $form = $response->createForm(CreateDatabaseForm::class, $user);

        try {
            new \PDO('mysql:dbname=' . $request->get('db_name') . ';host='. $request->get('db_host'),
                $request->get('db_user'),$request->get('db_pwd'));
        } catch (\Exception $exception) {
            $form->addErrors(['connection' => 'Impossible de se connecter à la base de données.']);
        }

        if (false === $form->handle($request)) {
            return $response->render("admin.install.smtp", "account", ["createDatabaseForm" => $form]);
        }

        EnvCreator::createOrUpdate(array_merge(
            $request->getParams(['db_name', 'db_pwd', 'db_host', 'db_user', 'db_prefixe']),
            ['db_driver' => 'mysql', 'env' => 'production']
        ));

        (new MigrationRunner())->run();

        return Router::redirect('install.show-smtp-form');
    }

    public function showSMTPForm(Request $request, Response $response)
    {
        $form = $response->createForm(CreateSMTPForm::class);

        $response->render("admin.install.smtp", "account", ["createSMTPForm" => $form]);
    }


    public function storeSMTPForm(Request $request, Response $response)
    {
        $request->setInputPrefix('createSMTPForm_');

        $form = $response->createForm(CreateSMTPForm::class, $user);

        $smtp = new SMTP();
        if (! $smtp->connect($request->get('smtp_host'), $request->get('smtp_port')))
            $form->addErrors(['connection' => 'Impossible de se connecter au serveur smtp.']);
        elseif (! empty($request->get('smtp_user')) && ! empty($request->get('smtp_pass')))
        {
            if (! $smtp->authenticate($request->get('smtp_user'), $request->get('smtp_pass')))
                $form->addErrors(['connection' => 'Impossible de se connecter au serveur smtp.']);
        }

        if (false === $form->handle($request)) {
            return $response->render("admin.install.smtp", "account", ["createSMTPForm" => $form]);
        }

        EnvCreator::createOrUpdate(
            $request->getParams(['smtp_host', 'smtp_port', 'smpt_user', 'smtp_pass'])
        );

        return Router::redirect('install.show-general-form');
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

        if (false === $form->handle($request)) {
            return $response->render("admin.install.general", "account", ["createInformationsForm" => $form]);
        }
    }
}