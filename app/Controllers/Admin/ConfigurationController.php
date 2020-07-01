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
        
        $form = $response->createForm(UpdateConfigurationForm::class, $object);

        $response->render("admin.configuration.index", "admin", ["updateConfigurationForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $configuration = (new Configuration())->hydrate($data);
        $form = $response->createForm(UpdateConfigurationForm::class, $configuration);
        
        if (false === $form->handle()) {
            $response->render("admin.configuration.index", "admin", ["updateConfigurationForm" => $form]);
        } else {
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
}