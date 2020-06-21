<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
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
        $data = $_POST;
        $manager = new ConfigurationManager();

        foreach($data as $key => $value){
            $config = (new QueryBuilder())
            ->select('*')
            ->from('configurations', 'c')
            ->where("libelle = '$key'")
            ->getQuery()
            ->getArrayResult(Configuration::class);

            $config[0]->setInfo($value);
            $manager->save($config[0]);
        }

        Router::redirect('admin.configuration.index');
    }
}