<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Configuration;
use App\Managers\ConfigurationManager;

class ConfigurationController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configurationManager = new ConfigurationManager();
        $configs = $configurationManager->findAll();

        $configFormConfig = Configuration::getAddConfigForm($configs);

        $myView = new View("admin.configuration.index", "admin");
        $myView->assign("configFormConfig", $configFormConfig);
    }

    public function store(Request $request, Response $response, array $args)
    {
        Router::redirect('admin.configuration.index');
    }
}