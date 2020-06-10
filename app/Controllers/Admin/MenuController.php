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
use App\Managers\ElementMenuManager;

class MenuController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $configTableMenu = Menu::getShowMenuTable();
        $myView = new View("admin.menu.index", "admin");
        $myView->assign("configTableMenu", $configTableMenu);
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
            $objet = new Menu();
        } else {
            $objet = new ElementMenu();
        }
        var_dump($objet);
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
        echo 'destroy';
    }
}