<?php

namespace App\Controllers\Admin;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
use App\Core\Sitemap;
use App\Core\View;
use App\Models\Configuration;
use App\Models\NavbarElement;
use App\Core\Controller\Controller;
use App\Managers\ConfigurationManager;
use App\Managers\NavbarElementManager;
use App\Forms\Configuration\CreateNavbarElementForm;
use App\Forms\Configuration\UpdateConfigurationForm;
use App\Forms\Configuration\UpdateNavbarElementForm;

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
        $object = (new ConfigurationManager())->find($args['config_id']);
        if (null === $object)
            return Router::redirect('admin.configuration.index');

        $form = $response->createForm(UpdateConfigurationForm::class, $object);

        $response->render("admin.configuration.parameter.edit", "admin", ["updateConfigurationForm" => $form]);
    }

    public function updateParams(Request $request, Response $response, array $args)
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

    public function createNavbar(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateNavbarElementForm::class);

        $response->render("admin.configuration.navbar.create", "admin", ["createNavbarElementForm" => $form]);
    }

    public function storeNavbar(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createNavbarElementForm_');

        $fields = $request->getParams(["name", "slug", "page"]);
        $fields["page"] = intval($fields["page"]);

        $object = (new NavbarElement())->hydrate($fields);

        $form = $response->createForm(CreateNavbarElementForm::class, $object);

        if (false === $form->handle($request))
            return $response->render("admin.configuration.navbar.create", "admin", ["createNavbarElementForm" => $form]);

        $slug = $object->getSlug();
        $route = "\$router->get('$slug', 'CustomPageController@display', '$slug');";

        // file_put_contents('customRoutes.php', $route, FILE_APPEND);

        (new NavbarElementManager())->save($object);
        Router::redirect('admin.configuration.index');
    }

    public function editNavbar(Request $request, Response $response, array $args)
    {
        $id = $args['navbar_element_id'];

        if (isset($id)) {
            $navbarElementManager = new NavbarElementManager();
            $navbarElement = $navbarElementManager->find($id);
        } else {
            throw new \Exception("L'id de l'élément n'existe pas.");
        }

        $form = $response->createForm(UpdateNavbarElementForm::class, $navbarElement);

        return $response->render("admin.configuration.navbar.edit", "admin", ["updateNavbarElementForm" => $form]);
    }

    public function updateNavbar(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('updateNavbarElementForm_');
        $fields = $request->getParams(["name", "slug", "page", "data_inserted"]);
        $fields["page"] = intval($fields["page"]);

        $response->checkFormData([
            "id" => intval($request->get("id")),
            "date_inserted" => $request->get("date_inserted"),
        ]);

        $object = (new NavbarElement())->hydrate($fields);
        $form = $response->createForm(UpdateNavbarElementForm::class, $object);

        if (false === $form->handle($request))
            return $response->render("admin.configuration.navbar.edit", "admin", ["updateNavbarElementForm" => $form]);

        (new NavbarElementManager())->save($object);
        return Router::redirect('admin.configuration.index');
    }

    public function destroyNavBar(Request $request, Response $response, array $args)
    {
        (new NavbarElementManager())->delete($args["navbar_element_id"]);
        return Router::redirect('admin.configuration.index');
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
            $dataConfiguration[] = [
                "name" => $data->getName(),
                "slug" => $data->getSlug(),
                "page" => $data->getPage()->getTitle(),
                "edit" => Router::getRouteByName('admin.configuration.navbar.edit', $data->getId()),
                "destroy" => Router::getRouteByName('admin.configuration.navbar.destroy', $data->getId()),
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
