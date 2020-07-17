<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Builder\QueryBuilder;
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
        $request->setInputPrefix('createElementMenuForm_');

        $elementMenu = (new ElementMenu())->hydrate($request->getParams(["nom", "description", "prix"]));
        $elementMenu->setCategorie($this->getCategorie($request->get("categorie")));
        
        $form = $response->createForm(CreateElementMenuForm::class, $elementMenu);
        
        if (false === $form->handle($request)) {
            $response->render("admin.menu.create", "admin", ["createMenuForm" => $form, "name" => "élément de menu"]);
        } else {
            (new ElementMenuManager())->save($elementMenu);       
            Router::redirect('admin.menu.index');
        }
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $object = (new ElementMenuManager())->find($args['elementmenu_id']);
        if (null === $object)
            return Router::redirect('admin.menu.index');
        
        $form = $response->createForm(UpdateElementMenuForm::class, $object);

        $response->render("admin.menu.edit", "admin", ["updateMenuForm" => $form, "name" => "élément de menu"]);
        
    }

    public function update(Request $request, Response $response, array $args)
    {
        $elementMenu = (new ElementMenuManager())->find($args['elementmenu_id']);
        if (null === $elementMenu)
            return Router::redirect('admin.menu.index');

        $request->setInputPrefix('updateMenuForm_');

        $elementMenu = $elementMenu->hydrate([
            'id' => $elementMenu->getId(),
            'nom' => $request->get("nom"),
            'description' => $request->get("description"),
            'prix' => $request->get("prix"),
            'categorie' => $this->getCategorie($request->get("categorie"))
        ]);
        
        $form = $response->createForm(UpdateElementMenuForm::class, $elementMenu);
        
        if (false === $form->handle($request)) {
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