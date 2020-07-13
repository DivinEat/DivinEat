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
use App\Forms\Configuration\UpdateConfigurationForm;

class ConfigurationController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configurationManager = new ConfigurationManager();
        $object = $configurationManager->findAll();

        $configTableConfiguration = Configuration::getShowConfigurationTable($object);

        $response->render("admin.configuration.index", "admin", ["configTableConfiguration" => $configTableConfiguration]);
    }

    public function edit(Request $request, Response $response, array $args)
    {   
        $id = $args['config_id'];

        if(isset($id)){
            $configurationManager = new ConfigurationManager();
            $object = $configurationManager->find($id);
        } else {
            throw new \Exception("L'id de le l'option n'existe pas.");
        }
        
        $form = $response->createForm(UpdateConfigurationForm::class, $object);

        $response->render("admin.configuration.edit", "admin", ["updateConfigurationForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $configuration = (new Configuration())->hydrate($data);
        $form = $response->createForm(UpdateConfigurationForm::class, $configuration);
        
        if (false === $form->handle($request)) {
            $response->render("admin.configuration.edit", "admin", ["updateConfigurationForm" => $form]);
        } else {
            (new ConfigurationManager())->save($configuration);       
            Router::redirect('admin.configuration.index');
        }
    }
}