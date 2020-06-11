<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Core\QueryBuilder;
use App\Models\Menu;
use App\Models\ElementMenu;
use App\Managers\MenuManager;
use App\Managers\ElementMenuManager;

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
        $configFormMenu = Menu::getAddMenuForm();
        $elementMenuManager = new ElementMenuManager();
        $elementsMenu = $elementMenuManager->findAll();

        $entrees = [];
        $plats = [];
        $desserts = [];
        foreach($elementsMenu as $elementMenu){
            switch($elementMenu->getCategorie()){
                case "entree":
                    $entrees[] = $elementMenu;
                    break;
                case "plat":
                    $plats[] = $elementMenu;
                    break;
                case "dessert":
                    $desserts[] = $elementMenu;
                    break;
            }
        }

        $myView = new View("admin.menu.create", "admin");
        $myView->assign("configFormMenu", $configFormMenu);
        $myView->assign("entrees", $entrees);
        $myView->assign("plats", $plats);
        $myView->assign("desserts", $desserts);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;
        if($data["categories"] == 1){
            $object = new Menu();
            $object->setNom($data['nomMenu']);
            $object->setEntree($data['entrees']);
            $object->setPlat($data['plats']);
            $object->setDessert($data['desserts']);
            $object->setPrix($this->calculPrixMenu($data));

            $manager = new MenuManager();
        } else {
            $object = new ElementMenu();
            $object->setCategorie($this->getCategorie($data['categories']));
            $object->setNom($data['nom']);
            $object->setDescription($data['description']);
            $object->setPrix($data['prix']);

            $manager = new ElementMenuManager();
        }

        $manager->save($object);

        Router::redirect('admin.menucreate');

    }

    public function show(Request $request, Response $response, array $args)
    {
        echo 'show';
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $configFormMenu = Menu::getAddMenuForm();

        $myView = new View("admin.menu.edit", "admin");
        $myView->assign("configFormMenu", $configFormMenu);
    }

    public function update(Request $request, Response $response, array $args)
    {
        echo 'update';
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $data = $_POST;
        $categorie = strtolower($data["categorie"]);
        if($categorie == "entrée"){
            $categorie = "entree";
        }

        if($categorie == "menu"){
            $manager = new MenuManager();
        } else {
            $manager = new MenuManager();
            $menus = $manager->findBy([
                $categorie => $data["id"]
            ]);

            foreach($menus as $menu){
                $method = "set".ucfirst($categorie);
                $menu->$method(NULL);

                $manager->save($menu);
            }

            $manager = new ElementMenuManager();
        }
        $manager->delete($data["id"]);

        Router::redirect('admin.menuindex');
    }

    public function calculPrixMenu($data){
        
        $elementMenuManager = new ElementMenuManager();

        $entree = $elementMenuManager->find($data['entrees']);
        $plat = $elementMenuManager->find($data['plats']);
        $dessert = $elementMenuManager->find($data['desserts']);
        
        return $entree->getPrix() + $plat->getPrix() + $dessert->getPrix();
    }

    public function getCategorie($categorie){
        switch($categorie){
            case 2:
                $nomCategorie = "entree";
                break;
            case 3:
                $nomCategorie = "plat";
                break;
            case 4:
                $nomCategorie = "dessert";
                break;
            case 5:
                $nomCategorie = "boisson";
                break;
        }
        return $nomCategorie;
    }
}