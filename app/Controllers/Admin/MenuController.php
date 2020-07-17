<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Menu;
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
        $request->setInputPrefix('createMenuForm_');

        $elementMenuManager = new ElementMenuManager();

        $object = new Menu();
        $object->setNom($request->get('nom'));

        $object->setEntree($elementMenuManager->find($request->get('entrees')));

        $object->setPlat($elementMenuManager->find($request->get('plats')));
        
        $object->setDessert($elementMenuManager->find($request->get('desserts')));

        $object->setPrix($this->calculPrixMenu($request));
        
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
        $object = (new MenuManager())->find($args['menu_id']);
        if (null === $object)
            return Router::redirect('admin.menu.index');
        
        $form = $response->createForm(UpdateMenuForm::class, $object);

        $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "menu"]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $object = (new MenuManager())->find($args['menu_id']);
        if (null === $object)
            return Router::redirect('admin.menu.index');

        $request->setInputPrefix('updateMenuForm_');
        
        $elementMenuManager = new ElementMenuManager();
        
        $object = $object->hydrate([
            'id' => $object->getId(),
            'nom' => $request->get("nom"),
            'entree' => $elementMenuManager->find($request->get('entrees'))->getId(),
            'plat' => $elementMenuManager->find($request->get('plats'))->getId(),
            'dessert' => $elementMenuManager->find($request->get('desserts'))->getId(),
            'prix' => $this->calculPrixMenu($request),
        ]);
        
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

    public function calculPrixMenu(Request $request){
        
        $elementMenuManager = new ElementMenuManager();

        if($request->get('entrees') != 0){
            $entree = $elementMenuManager->find($request->get('entrees'));
            $prixEntree = $entree->getPrix();
        } else {
            $prixEntree = 0;
        }
        if($request->get('plats') != 0){
            $plat = $elementMenuManager->find($request->get('plats'));
            $prixPlat = $plat->getPrix();
        } else {
            $prixPlat = 0;
        }
        if($request->get('desserts') != 0){
            $dessert = $elementMenuManager->find($request->get('desserts'));
            $prixDessert = $dessert->getPrix();
        } else {
            $prixDessert = 0;
        }
        
        return $prixEntree + $prixPlat + $prixDessert;
    }
}