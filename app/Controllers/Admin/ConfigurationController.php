<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Models\Configuration;
use App\Managers\ConfigurationManager;
use App\Forms\Configuration\UpdateConfigurationForm;
use App\Managers\NavbarElementManager;

class ConfigurationController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configurationData = $this->getConfigurationData();
        $navbarData = $this->getNavbarData();

        $response->render("admin.configuration.index", "admin", [
            "configurationData" => $configurationData,
            "navbarData" => $navbarData,
        ]);
    }

    public function editParams(Request $request, Response $response, array $args)
    {
        $id = $args['config_id'];

        if (isset($id)) {
            $configurationManager = new ConfigurationManager();
            $object = $configurationManager->find($id);
        } else {
            throw new \Exception("L'id de le l'option n'existe pas.");
        }

        $form = $response->createForm(UpdateConfigurationForm::class, $object);

        $response->render("admin.configuration.parameter.edit", "admin", ["updateConfigurationForm" => $form]);
    }

    public function updateParams(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach ($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $configuration = (new Configuration())->hydrate($data);
        $form = $response->createForm(UpdateConfigurationForm::class, $configuration);

        if (false === $form->handle()) {
            $response->render("admin.configuration.edit", "admin", ["updateConfigurationForm" => $form]);
        } else {
            (new ConfigurationManager())->save($configuration);
            Router::redirect('admin.configuration.index');
        }
    }

    public function createNavbar()
    {

        
    }

    public function editNavbar()
    {
    }

    public function updateNavbar()
    {
    }

    private function getConfigurationData(): array
    {
        $configurationManager = new ConfigurationManager();
        $datas = $configurationManager->findAll();

        $dataConfiguration = [];
        foreach ($datas as $data) {
            $dataConfiguration[] = [
                "libelle" => ucwords(str_replace("_", " ", $data->getLibelle())),
                "info" => $data->getInfo(),
                "edit" => Router::getRouteByName('admin.configuration.parameter.edit', $data->getId())
            ];
        }

        $data = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Libelle",
                "Informations",
                "Actions"
            ],

            "fields" => [
                "Configuration" => $dataConfiguration
            ]
        ];

        return $data;
    }

    private function getNavbarData(): array
    {
        $navbarManager = new NavbarElementManager();
        $datas = $navbarManager->findAll();

        $dataConfiguration = [];
        foreach ($datas as $data) {
            $tabConfigs[] = [
                "name" => $data->getName(),
                "slug" => $data->getSlug(),
                "page" => $data->getPage()->getTitle(),
                "delete" => Router::getRouteByName('admin.configuration.navbar.destroy', $data->getId()),
                "edit" => Router::getRouteByName('admin.configuration.navbar.edit', $data->getId())
            ];
        }

        $data = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Nom",
                "Slug",
                "Page",
                "Actions"
            ],

            "fields" => [
                "Configuration" => $dataConfiguration
            ]
        ];

        return $data;
    }
}
