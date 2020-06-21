<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Builder\QueryBuilder;
use App\Core\View;
use App\Models\Menu;
use App\Models\Article;
use App\Models\ElementMenu;
use App\Managers\MenuManager;
use App\Managers\ElementMenuManager;
use App\Managers\ConfigurationManager;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $menus =  (new QueryBuilder())
            ->select('*')
            ->from('menus', 'm')
            ->limit('6')
            ->getQuery()
            ->getArrayResult(Menu::class);

        $articles =  (new QueryBuilder())
            ->select('*')
            ->from('articles', 'a')
            ->orderBy('id', 'DESC')
            ->limit('1')
            ->getQuery()
            ->getArrayResult(Article::class);

        $configManager = new ConfigurationManager();
        $configs = $configManager->findAll();

        $myView = new View("home", "main");
        $myView->assign("menus", $menus);
        $myView->assign("articles", $articles);
        $myView->assign("configs", $configs);
    }

    public function menus(Request $request, Response $response)
    {
        $menuManager = new MenuManager();
        $menus = $menuManager->findAll();

        $elementMenuManager = new ElementMenuManager();
        $elementMenus = $elementMenuManager->findAll();

        $desserts = (new QueryBuilder())
            ->select('*')
            ->from('elementmenus', 'm')
            ->where("categorie = 'dessert'")
            ->getQuery()
            ->getArrayResult(ElementMenu::class);

        $plats = (new QueryBuilder())
            ->select('*')
            ->from('elementmenus', 'm')
            ->where("categorie = 'plat'")
            ->getQuery()
            ->getArrayResult(ElementMenu::class);

        $myView = new View("menu.index", "main");
        $myView->assign("menus", $menus);
        $myView->assign("elementMenus", $elementMenus);
        $myView->assign("desserts", $desserts);
        $myView->assign("plats", $plats);
    }
}