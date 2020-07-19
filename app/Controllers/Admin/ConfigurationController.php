<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Menu;
use App\Core\Sitemap;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\PageManager;
use App\Models\Configuration;
use App\Models\NavbarElement;
use App\Managers\ImageManager;
use App\Core\Builder\QueryBuilder;
use App\Core\Controller\Controller;
use App\Managers\ConfigurationManager;
use App\Managers\NavbarElementManager;
use App\Core\Migration\MigrationRunner;
use App\Forms\Configuration\CreateLogoForm;
use App\Forms\Configuration\CreateImageForm;
use App\Forms\Configuration\CreateBannerForm;
use App\Forms\Configuration\CreateFaviconForm;
use App\Forms\Configuration\CreateNavbarElementForm;
use App\Forms\Configuration\UpdateConfigurationForm;
use App\Forms\Configuration\UpdateNavbarElementForm;

class ConfigurationController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configurationData = $this->getConfigurationData();
        $navbarData = $this->getNavbarData();
        $configurationSlider = $this->getConfigurationSlider();

        $createLogoForm = $response->createForm(CreateLogoForm::class);
        $createBannerForm = $response->createForm(CreateBannerForm::class);
        $createFaviconForm = $response->createForm(CreateFaviconForm::class);

        $response->render("admin.configuration.index", "admin", [
            "configurationData" => $configurationData,
            "navbarData" => $navbarData,
            "configurationSlider" => $configurationSlider,
            "createLogoForm" => $createLogoForm,
            "createBannerForm" => $createBannerForm,
            "createFaviconForm" => $createFaviconForm
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
        Sitemap::generate();die;

        return Router::redirect('admin.configuration.index');
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

        (new NavbarElementManager())->save($object);
        Router::redirect('admin.configuration.index');
    }

    public function editNavbar(Request $request, Response $response, array $args)
    {
        $navbarElement = (new NavbarElementManager())->find($args['navbar_element_id']);
        if (null === $navbarElement)
            return Router::redirect('admin.configuration.index');

        $form = $response->createForm(UpdateNavbarElementForm::class, $navbarElement);

        return $response->render("admin.configuration.navbar.edit", "admin", ["updateNavbarElementForm" => $form]);
    }

    public function updateNavbar(Request $request, Response $response, array $args)
    {
        $navbarElement = (new NavbarElementManager())->find($args['navbar_element_id']);
        if (null === $navbarElement)
            return Router::redirect('admin.configuration.index');

        $request->setInputPrefix('updateNavbarElementForm_');

        $navbarElement->setName($request->get("name"));
        $navbarElement->setSlug($request->get("slug"));
        $navbarElement->setPage((new PageManager())->find($request->get("page")));

        $form = $response->createForm(UpdateNavbarElementForm::class, $navbarElement);

        if (false === $form->handle($request))
            return $response->render("admin.configuration.navbar.edit", "admin", ["updateNavbarElementForm" => $form]);

        (new NavbarElementManager())->save($navbarElement);
        
        return Router::redirect('admin.configuration.index');
    }

    public function destroyNavBar(Request $request, Response $response, array $args)
    {
        (new NavbarElementManager())->delete($args["navbar_element_id"]);
        return Router::redirect('admin.configuration.index');
    }


    /* SLIDER */
    public function createSlider(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateImageForm::class);

        $response->render("admin.configuration.slider.create", "admin", ["createConfigurationForm" => $form]);
    }

    public function storeSlider(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createConfigurationForm_');
        
        $form = $response->createForm(CreateImageForm::class);

        $file = $request->get("file");

        if($file["error"] !== 0) 
            $form->addErrors(["error" => "Impossible de téléverser le fichier !"]);  
        
        if (false === $form->handle($request))
            return $response->render("admin.configuration.slider.create", "admin", ["createConfigurationForm" => $form]);

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        $path = uniqid() . "." . $ext;

        if(move_uploaded_file($file["tmp_name"], ROOT ."/public/img/uploadedImages/" . $path)){
            $image = (new ImageManager())->create([
                'name' => $file["name"],
                'path' => $path,
            ]);
        }

        (new ConfigurationManager())->create([
            'libelle' => uniqid('slider_'),
            'info' => $image->getId()
        ]);

        Router::redirect('admin.configuration.index');
    }

    public function destroySlider(Request $request, Response $response, array $args)
    {
        (new ConfigurationManager())->delete($args["slider_element_id"]);

        return Router::redirect('admin.configuration.index');
    }
    /* SLIDER */

    /* LOGO */
    public function updateLogo(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createLogoForm_');
        
        $form = $response->createForm(CreateLogoForm::class);

        $file = $request->get("file");

        if($file["error"] !== 0) 
            $form->addErrors(["error" => "Impossible de téléverser le fichier !"]);  
        
        if (false === $form->handle($request)){
            $configurationData = $this->getConfigurationData();
            $navbarData = $this->getNavbarData();
            $configurationSlider = $this->getConfigurationSlider();
            $createBannerForm = $response->createForm(CreateBannerForm::class);
            $createFaviconForm = $response->createForm(CreateFaviconForm::class);

            return $response->render("admin.configuration.index", "admin", [
                "configurationData" => $configurationData,
                "navbarData" => $navbarData,
                "configurationSlider" => $configurationSlider,
                "createLogoForm" => $form,
                "createBannerForm" => $createBannerForm,
                "createFaviconForm" => $createFaviconForm
            ]);
        }

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        $path = uniqid() . "." . $ext;

        if(move_uploaded_file($file["tmp_name"], ROOT . "/public/img/uploadedImages/" . $path)){
            $image = (new ImageManager())->create([
                'name' => $file["name"],
                'path' => $path,
            ]);
        }

        $logo = current((new ConfigurationManager())->findBy(['libelle' => 'logo']));
        $logo->setInfo($image->getId());
        (new ConfigurationManager())->save($logo);

        Router::redirect('admin.configuration.index');
    }

    /* BANNER */
    public function updateBanner(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createBannerForm_');
        
        $form = $response->createForm(CreateBannerForm::class);

        $file = $request->get("file");

        if($file["error"] !== 0) 
            $form->addErrors(["error" => "Impossible de téléverser le fichier !"]);  
        
        if (false === $form->handle($request)){
            $configurationData = $this->getConfigurationData();
            $navbarData = $this->getNavbarData();
            $configurationSlider = $this->getConfigurationSlider();
            $createLogoForm = $response->createForm(CreateLogoForm::class);
            $createFaviconForm = $response->createForm(CreateFaviconForm::class);

            return $response->render("admin.configuration.index", "admin", [
                "configurationData" => $configurationData,
                "navbarData" => $navbarData,
                "configurationSlider" => $configurationSlider,
                "createBannerForm" => $form,
                "createLogoForm" => $createLogoForm,
                "createFaviconForm" => $createFaviconForm
            ]);
        }

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        $path = uniqid() . "." . $ext;

        if(move_uploaded_file($file["tmp_name"], "img/uploadedImages/" . $path)){
            $image = (new ImageManager())->create([
                'name' => $file["name"],
                'path' => $path,
            ]);
        }

        $banner = current((new ConfigurationManager())->findBy(['libelle' => 'banner']));
        $banner->setInfo($image->getId());
        (new ConfigurationManager())->save($banner);

        Router::redirect('admin.configuration.index');
    }

    /* BANNER */
    public function updateFavicon(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createFaviconForm_');
        
        $form = $response->createForm(CreateFaviconForm::class);

        $file = $request->get("file");

        if($file["error"] !== 0) 
            $form->addErrors(["error" => "Impossible de téléverser le fichier !"]);  
        
        if (false === $form->handle($request)){
            $configurationData = $this->getConfigurationData();
            $navbarData = $this->getNavbarData();
            $configurationSlider = $this->getConfigurationSlider();
            $createLogoForm = $response->createForm(CreateLogoForm::class);
            $createBannerForm = $response->createForm(CreateBannerForm::class);

            return $response->render("admin.configuration.index", "admin", [
                "configurationData" => $configurationData,
                "navbarData" => $navbarData,
                "configurationSlider" => $configurationSlider,
                "createBannerForm" => $createBannerForm,
                "createLogoForm" => $createLogoForm,
                "createFaviconForm" => $form
            ]);
        }

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        $path = uniqid() . "." . $ext;

        if(move_uploaded_file($file["tmp_name"], "img/uploadedImages/" . $path)){
            $image = (new ImageManager())->create([
                'name' => $file["name"],
                'path' => $path,
            ]);
        }

        $favicon = current((new ConfigurationManager())->findBy(['libelle' => 'favicon']));
        $favicon->setInfo($image->getId());
        (new ConfigurationManager())->save($favicon);

        Router::redirect('admin.configuration.index');
    }

    private function getConfigurationData(): array
    {
        $datas = (new QueryBuilder())
            ->select('*')
            ->from('configurations', 'c')
            ->where('libelle IN (\'nom_du_site\', \'email\', \'facebook\', \'linkedin\', \'instagram\')')
            ->getQuery()
            ->getArrayResult(Configuration::class);

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

    private function getConfigurationSlider(): array
    {
        $datas = (new QueryBuilder())
            ->select('*')
            ->from('configurations', 'c')
            ->where('libelle LIKE \'slider_%\'')
            ->getQuery()
            ->getArrayResult(Configuration::class);

        $dataConfiguration = [];
        foreach ($datas as $data) {
            $dataConfiguration[] = [
                "libelle" => ucwords(str_replace("_", " ", $data->getLibelle())),
                "info" => $data->getInfo(),
                "destroy" => Router::getRouteByName('admin.configuration.slider.destroy', $data->getId()),
            ];
        }

        $data = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Libelle",
                "Image",
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
