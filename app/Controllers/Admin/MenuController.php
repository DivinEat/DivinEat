<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Menu;
use App\Models\ElementMenu;
use App\Managers\MenuManager;
use App\Managers\ElementMenuManager;
use App\Forms\Menu\CreateMenuForm;
use App\Forms\Menu\UpdateMenuForm;

class MenuController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $elementMenuManager = new ElementMenuManager();
        $elementsMenus = $elementMenuManager->findAll();

        $menuManager = new MenuManager();
        $menus = $menuManager->findAll();

        $configTableMenu = Menu::getShowMenuTable($menus);

        $configTableElementMenu = Menu::getShowElementMenuTable($elementsMenus);

        $myView = new View("admin.menu.index", "admin");
        $myView->assign("configTableMenu", $configTableMenu);
        $myView->assign("configTableElementMenu", $configTableElementMenu);
    }

    public function create(Request $request, Response $response)
    {
        $form = $response->createForm(CreateMenuForm::class);

        $response->render("admin.menu.create", "admin", ["createMenuForm" => $form, "name" => "menu"]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $elementMenuManager = new ElementMenuManager();

        $object = new Menu();
        $object->setNom($data['nom']);

        if($data['entrees'] == 0) $data['entrees'] = NULL;
        $object->setEntree($elementMenuManager->find($data['entrees']));

        if($data['plats'] == 0) $data['plats'] = NULL;
        $object->setPlat($elementMenuManager->find($data['plats']));
        
        if($data['desserts'] == 0) $data['desserts'] = NULL;
        $object->setDessert($elementMenuManager->find($data['desserts']));

        $object->setPrix($this->calculPrixMenu($data));
        
        $form = $response->createForm(CreateMenuForm::class, $object);
        
        if (false === $form->handle($request)) {
            $response->render("admin.menu.create", "admin", ["createMenuForm" => $form, "name" => "menu"]);
        } else {
            (new MenuManager())->save($object);       
            Router::redirect('admin.menu.index');
        }
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args['menu_id'];

        if(isset($id)){
            $menuManager = new MenuManager();
            $object = $menuManager->find($id);
        } else {
            throw new \Exception("L'id du menu n'existe pas.");
        }
        
        $form = $response->createForm(UpdateMenuForm::class, $object);

        $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "menu"]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $elementMenuManager = new ElementMenuManager();

        $object = new Menu();
        $object->setId($data['id']);

        $object->setNom($data['nom']);

        if($data['entrees'] == 0) $data['entrees'] = NULL;
        $object->setEntree($elementMenuManager->find($data['entrees']));

        if($data['plats'] == 0) $data['plats'] = NULL;
        $object->setPlat($elementMenuManager->find($data['plats']));
        
        if($data['desserts'] == 0) $data['desserts'] = NULL;
        $object->setDessert($elementMenuManager->find($data['desserts']));

        $object->setPrix($this->calculPrixMenu($data));
        
        $form = $response->createForm(UpdateMenuForm::class, $object);
        
        if (false === $form->handle($request)) {
            $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "menu"]);
        } else {
            (new MenuManager())->save($object);       
            Router::redirect('admin.menu.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new MenuManager();
        
        $manager->delete($args["menu_id"]);

        Router::redirect('admin.menu.index');
    }

    public function calculPrixMenu($data){
        
        $elementMenuManager = new ElementMenuManager();

        if($data['entrees'] != 0){
            $entree = $elementMenuManager->find($data['entrees']);
            $prixEntree = $entree->getPrix();
        } else {
            $prixEntree = 0;
        }
        if($data['plats'] != 0){
            $plat = $elementMenuManager->find($data['plats']);
            $prixPlat = $plat->getPrix();
        } else {
            $prixPlat = 0;
        }
        if($data['desserts'] != 0){
            $dessert = $elementMenuManager->find($data['desserts']);
            $prixDessert = $dessert->getPrix();
        } else {
            $prixDessert = 0;
        }
        
        return $prixEntree + $prixPlat + $prixDessert;
    }
}