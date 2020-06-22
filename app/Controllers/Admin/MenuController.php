<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
use App\Core\View;
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
            $elementMenuManager = new ElementMenuManager();

            $object = new Menu();
            $object->setNom($data['nomMenu']);

            if($data['entrees'] == 0) $data['entrees'] = NULL;
            $object->setEntree($elementMenuManager->find($data['entrees']));

            if($data['plats'] == 0) $data['plats'] = NULL;
            $object->setPlat($elementMenuManager->find($data['plats']));
            
            if($data['desserts'] == 0) $data['desserts'] = NULL;
            $object->setDessert($elementMenuManager->find($data['desserts']));
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

        Router::redirect('admin.menu.create');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $categorie = $args["categorie_id"];
        $id = $args["menu_id"];

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

        if(isset($id)){
            if($categorie == 1){
                $manager= new MenuManager();
                $object = $manager->find($id);
                $configFormMenu = Menu::getEditMenuForm($id);
            } else {
                $manager = new ElementMenuManager();
                $object = $manager->find($id);
                $configFormMenu = Menu::getEditElementMenuForm($id, $categorie);
            }
        }

        $myView = new View("admin.menu.edit", "admin");
        $myView->assign("configFormMenu", $configFormMenu);
        $myView->assign("entrees", $entrees);
        $myView->assign("plats", $plats);
        $myView->assign("desserts", $desserts);
        $myView->assign("categorie", $this->getCategorie($categorie));
        $myView->assign("object", $object);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;
        $categorie = $this->getCategorie($args["categorie_id"]);

        if($categorie == "menu"){
            $elementMenuManager = new ElementMenuManager();
            $manager = new MenuManager();

            $object = new Menu();
            $object->setId($args["menu_id"]);

            $object->setNom($data['nomMenu']);

            if($data['entrees'] == 0) $data['entrees'] = NULL;
            $object->setEntree($elementMenuManager->find($data['entrees']));

            if($data['plats'] == 0) $data['plats'] = NULL;
            $object->setPlat($elementMenuManager->find($data['plats']));
            
            if($data['desserts'] == 0) $data['desserts'] = NULL;
            $object->setDessert($elementMenuManager->find($data['desserts']));

            $object->setPrix($this->calculPrixMenu($data));
        } else {
            $manager = new ElementMenuManager();

            $object = new ElementMenu();
            $object->setId($args["menu_id"]);
            $object->setCategorie($categorie);
            $object->setNom($data['nom']);
            $object->setDescription($data['description']);
            $object->setPrix($data['prix']);
        }

        $manager->save($object);

        Router::redirect('admin.menu.index');
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $categorie = $this->getCategorie($args["categorie_id"]);

        if($categorie == "menu"){
            $manager = new MenuManager();
        } else {
            $manager = new ElementMenuManager();

            $menus =  (new QueryBuilder())->select('*')->from('menus', 'm');
            switch($categorie){
                case "entree":
                    $menus->where('m.entree = :id');
                    break;
                case "plat":
                    $menus->where('m.plat = :id');
                    break;
                case "dessert":
                    $menus->where('m.dessert = :id');
                    break;
            }
            $menus->setParameter('id', $args["menu_id"])->getQuery()->getArrayResult(Menu::class);
            if(empty($menus)){
                die("Merci de supprimer les menus qui utilisent cet élément de menu");
            }
        }
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

    public function getCategorie($categorie){
        switch($categorie){
            case 1:
                $nomCategorie = "menu";
                break;
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