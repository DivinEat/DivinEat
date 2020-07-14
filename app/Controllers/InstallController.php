<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Migration\MigrationRunner;

class InstallController extends Controller
{
    public function showDatabaseForm(Request $request, Response $response)
    {
        $migrationRunner = new MigrationRunner(DB_PREFIXE);
        $migrationRunner->run();
//        return $response->render('admin.install.database', 'account');
    }

    public function storeDatabaseForm(Request $request, Response $response)
    {

    }
}