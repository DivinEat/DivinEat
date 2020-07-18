<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
use App\Core\Sitemap;
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
        $object = (new ConfigurationManager())->find($args['config_id']);
        if (null === $object)
            return Router::redirect('admin.configuration.index');
        
        $form = $response->createForm(UpdateConfigurationForm::class, $object);

        $response->render("admin.configuration.edit", "admin", ["updateConfigurationForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $configuration = (new ConfigurationManager())->find($args['config_id']);
        if (null === $configuration)
            return Router::redirect('admin.configuration.index');

        $request->setInputPrefix('updateConfigurationForm_');
        
        $configuration = $configuration->hydrate([
            'id' => $configuration->getId(),
            'libelle' => $request->get("libelle"),
            'info' => $request->get("info"),
        ]);

        $form = $response->createForm(UpdateConfigurationForm::class, $configuration);
        
        if (false === $form->handle($request)) {
            $response->render("admin.configuration.edit", "admin", ["updateConfigurationForm" => $form]);
        } else {
            (new ConfigurationManager())->save($configuration);       
            Router::redirect('admin.configuration.index');
        }
    }

    public function sitemapGenerate(Request $request, Response $response)
    {
        Sitemap::generate();
    }
}