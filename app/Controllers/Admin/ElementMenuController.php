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
use App\Managers\ElementMenuManager;
use App\Forms\Menu\CreateElementMenuForm;
use App\Forms\Menu\UpdateElementMenuForm;

class ElementMenuController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $form = $response->createForm(CreateElementMenuForm::class);

        $response->render("admin.menu.create", "admin", ["createMenuForm" => $form, "name" => "élément de menu"]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }

        $data["categorie"] = $this->getCategorie($data["categorie"]);

        $elementMenu = (new ElementMenu())->hydrate($data);
        
        $form = $response->createForm(CreateElementMenuForm::class, $elementMenu);
        
        if (false === $form->handle()) {
            $response->render("admin.menu.create", "admin", ["createMenuForm" => $form, "name" => "élément de menu"]);
        } else {
            (new ElementMenuManager())->save($elementMenu);       
            Router::redirect('admin.menu.index');
        }
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args['elementmenu_id'];

        if(isset($id)){
            $ElementMenuManager = new ElementMenuManager();
            $object = $ElementMenuManager->find($id);
        } else {
            throw new \Exception("L'id de l'élément de menu n'existe pas.");
        }
        
        $form = $response->createForm(UpdateElementMenuForm::class, $object);

        $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "élément de menu"]);
        
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        foreach($data as $elementName => $element) {
            $data[explode("_", $elementName)[1]] = $data[$elementName];
            unset($data[$elementName]);
        }
        
        $data["categorie"] = $this->getCategorie($data["categorie"]);

        $elementMenu = (new ElementMenu())->hydrate($data);
        
        $form = $response->createForm(UpdateElementMenuForm::class, $elementMenu);
        
        if (false === $form->handle()) {
            $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "menu"]);
        } else {
            (new ElementMenuManager())->save($elementMenu);       
            Router::redirect('admin.menu.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $categorie = $this->getCategorie($args["categorie_id"]);

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
        $menus->setParameter('id', $args["elementmenu_id"])->getQuery()->getArrayResult(Menu::class);
        if(empty($menus)){
            die("Merci de supprimer les menus qui utilisent cet élément de menu");
        }
        
        $manager->delete($args["elementmenu_id"]);

        Router::redirect('admin.menu.index');
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