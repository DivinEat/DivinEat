<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Horaire;
use App\Managers\HoraireManager;
use App\Forms\Horaire\CreateHoraireForm;
use App\Forms\Horaire\UpdateHoraireForm;

class HoraireController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $configTableHoraire = Horaire::getShowHoraireTable($horaires);

        $response->render("admin.horaire.index", "admin", ["configTableHoraire" => $configTableHoraire]);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateHoraireForm::class);

        $response->render("admin.horaire.create", "admin", ["createHoraireForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createHoraireForm_');
        
        $horaire = (new horaire())->hydrate($request->getParams(["horaire"]));
        
        $form = $response->createForm(CreateHoraireForm::class, $horaire);
        
        if (false === $form->handle()) {
            $response->render("admin.horaire.create", "admin", ["createHoraireForm" => $form]);
        } else {
            (new HoraireManager())->save($horaire);       
            Router::redirect('admin.horaire.index');
        }
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args['horaire_id'];

        if(isset($id)){
            $horaireManager = new HoraireManager();
            $object = $horaireManager->find($id);
        } else {
            throw new \Exception("L'id de l'horaire n'existe pas.");
        }
        
        $form = $response->createForm(UpdateHoraireForm::class, $object);

        $response->render("admin.horaire.edit", "admin", ["updateHoraireForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('updateHoraireForm_');
        
        $horaire = (new horaire())->hydrate($request->getParams(["id", "horaire"]));
        
        $form = $response->createForm(UpdateHoraireForm::class, $horaire);
        
        if (false === $form->handle()) {
            $response->render("admin.horaire.edit", "admin", ["updateHoraireForm" => $form]);
        } else {
            (new HoraireManager())->save($horaire);       
            Router::redirect('admin.horaire.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new HoraireManager();
        $manager->delete($args["horaire_id"]);

        Router::redirect('admin.horaire.index');
    }
}